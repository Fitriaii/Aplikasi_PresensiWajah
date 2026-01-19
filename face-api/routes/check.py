import cv2
import numpy as np
import base64
import traceback
from fastapi import APIRouter
from pydantic import BaseModel
from utils.insight_engine import face_app

router = APIRouter()


# ========================== #
# Schema
# ========================== #
class CheckRequest(BaseModel):
    image: str


class CheckResponse(BaseModel):
    status: str
    message: str | None
    can_register: bool


# ========================== #
# Endpoint
# ========================== #
@router.post("/check", response_model=CheckResponse)
def check(req: CheckRequest):
    try:
        return check_face(req.image)

    except Exception:
        print("FACE CHECK ERROR")
        traceback.print_exc()
        return {
            "status": "searching",
            "message": "Face processing error",
            "can_register": False
        }


# ========================== #
# Decode Base64 Image
# ========================== #
def decode_image(base64_str: str):
    try:
        img_data = base64.b64decode(base64_str.split(",")[-1])
        img_arr = np.frombuffer(img_data, np.uint8)
        img = cv2.imdecode(img_arr, cv2.IMREAD_COLOR)

        if img is None:
            raise ValueError("Decoded image is None")

        # 🔥 PAKSA ukuran minimal
        h, w, _ = img.shape
        if w < 640:
            scale = 640 / w
            img = cv2.resize(
                img,
                (int(w * scale), int(h * scale)),
                interpolation=cv2.INTER_LINEAR
            )

        return img

    except Exception:
        return None


# ========================== #
# Brightness
# ========================== #
def get_brightness(img_bgr):
    yuv = cv2.cvtColor(img_bgr, cv2.COLOR_BGR2YUV)
    return float(np.mean(yuv[:, :, 0]))


# ========================== #
# Face Check Logic
# ========================== #
def check_face(base64_image: str):
    img_bgr = decode_image(base64_image)

    if img_bgr is None:
        return {
            "status": "searching",
            "message": "Gambar tidak valid",
            "can_register": False
        }

    # 🔥 WAJIB RGB UNTUK INSIGHTFACE
    img_rgb = cv2.cvtColor(img_bgr, cv2.COLOR_BGR2RGB)

    h, w, _ = img_rgb.shape
    img_area = w * h

    # ===================== #
    # Face Detection
    # ===================== #
    faces = face_app.get(img_rgb)

    print("Image shape:", img_rgb.shape)
    print("Faces detected:", len(faces))

    if not faces:
        return {
            "status": "searching",
            "message": "Wajah tidak terdeteksi",
            "can_register": False
        }

    # Ambil wajah terbesar
    face = max(
        faces,
        key=lambda f: max(1, (f.bbox[2] - f.bbox[0])) * max(1, (f.bbox[3] - f.bbox[1]))
    )

    x1, y1, x2, y2 = map(int, face.bbox)

    # 🔥 Clamp bbox
    x1 = max(0, x1)
    y1 = max(0, y1)
    x2 = min(w, x2)
    y2 = min(h, y2)

    face_w = max(1, x2 - x1)
    face_h = max(1, y2 - y1)
    face_area = face_w * face_h

    ratio = face_area / img_area
    brightness = get_brightness(img_bgr)

    print("Face ratio:", ratio)
    print("Brightness:", brightness)

    # ===================== #
    # Validation Rules
    # ===================== #
    if ratio < 0.04:
        return {
            "status": "too_far",
            "message": "Wajah terlalu jauh",
            "can_register": False
        }

    if ratio > 0.5:
        return {
            "status": "too_close",
            "message": "Wajah terlalu dekat",
            "can_register": False
        }

    if brightness < 70:
        return {
            "status": "too_dark",
            "message": "Pencahayaan terlalu gelap",
            "can_register": False
        }

    if brightness > 220:
        return {
            "status": "too_bright",
            "message": "Pencahayaan terlalu terang",
            "can_register": False
        }

    # ===================== #
    # SUCCESS
    # ===================== #
    return {
        "status": "good",
        "message": "Wajah ideal",
        "can_register": True
    }
