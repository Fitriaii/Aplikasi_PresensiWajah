import os
import json
import numpy as np
from fastapi import APIRouter
from pydantic import BaseModel
from utils.insight_engine import face_app  # pastikan ini adalah FaceAnalysis instance
from utils.image_utils import decode_image

router = APIRouter()

EMBEDDING_DIR = "dataset/embeddings"
META_DIR = "dataset/meta"

os.makedirs(EMBEDDING_DIR, exist_ok=True)
os.makedirs(META_DIR, exist_ok=True)


# ========================== #
# Schema
# ========================== #
class RegisterRequest(BaseModel):
    peserta_id: str
    name: str
    image: str  # base64 string


# ========================== #
# Register Endpoint
# ========================== #
@router.post("/register")
def register_face(payload: RegisterRequest):
    # Decode base64 → cv2 image
    img = decode_image(payload.image)
    if img is None:
        return {
            "success": False,
            "message": "Image tidak valid"
        }

    # Deteksi wajah → gunakan .get(), bukan callable
    faces = face_app.get(img)  # ✅ pastikan 'face_app' adalah FaceAnalysis instance
    if not faces:
        return {
            "success": False,
            "message": "Tidak ada wajah terdeteksi"
        }

    if len(faces) != 1:
        return {
            "success": False,
            "message": "Pastikan hanya satu wajah terdeteksi"
        }

    embedding = faces[0].embedding

    # ========================== #
    # Simpan embedding
    # ========================== #
    emb_path = os.path.join(EMBEDDING_DIR, f"{payload.peserta_id}.npy")

    if os.path.exists(emb_path):
        existing = np.load(emb_path)
        existing = np.vstack([existing, embedding])
        np.save(emb_path, existing)
        total = existing.shape[0]
    else:
        np.save(emb_path, np.array([embedding]))
        total = 1

    # ========================== #
    # Simpan meta
    # ========================== #
    meta_path = os.path.join(META_DIR, f"{payload.peserta_id}.json")
    meta_data = {
        "peserta_id": payload.peserta_id,
        "name": payload.name
    }

    with open(meta_path, "w", encoding="utf-8") as f:
        json.dump(meta_data, f, ensure_ascii=False, indent=2)

    return {
        "success": True,
        "message": "Wajah berhasil diregistrasi",
        "peserta_id": payload.peserta_id,
        "name": payload.name,
        "total_embedding": total
    }
