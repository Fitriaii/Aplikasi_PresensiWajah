import os
import json
import numpy as np
from fastapi import APIRouter, HTTPException
from pydantic import BaseModel, Field
from utils.insight_engine import face_app
from utils.image_utils import decode_image

router = APIRouter()

EMBEDDING_DIR = "dataset/embeddings"
META_DIR = "dataset/meta"


# ========================== #
# Schema
# ========================== #
class RecognizeRequest(BaseModel):
    image: str = Field(..., description="Base64 image string")


# ========================== #
# Helper: cosine similarity
# ========================== #
def cosine_similarity(a, b):
    a = a.astype(np.float32)
    b = b.astype(np.float32)
    return np.dot(a, b) / (np.linalg.norm(a) * np.linalg.norm(b))


# ========================== #
# Recognize Endpoint
# ========================== #
@router.post("/recognize")
def recognize_face(payload: RecognizeRequest):
    try:
        # ---------------------------- #
        # Decode base64 → image
        # ---------------------------- #
        img = decode_image(payload.image)
        if img is None:
            return {"success": False, "message": "Image tidak valid"}

        # ---------------------------- #
        # Deteksi wajah InsightFace
        # ---------------------------- #
        faces = face_app.get(img)

        if not faces:
            return {"success": False, "message": "Tidak ada wajah terdeteksi"}

        if len(faces) != 1:
            return {
                "success": False,
                "message": "Pastikan hanya satu wajah terdeteksi"
            }

        # embedding untuk wajah yang ingin dikenali
        target_emb = faces[0].embedding

        # ---------------------------- #
        # Load semua user embeddings
        # ---------------------------- #
        best_score = -1
        best_user = None
        best_name = None

        for file in os.listdir(EMBEDDING_DIR):
            if not file.endswith(".npy"):
                continue

            peserta_id = file.replace(".npy", "")
            emb_path = os.path.join(EMBEDDING_DIR, file)

            embeddings = np.load(emb_path)  # array [(N, 512)]
            if embeddings.ndim == 1:
                embeddings = embeddings.reshape(1, -1)

            # hitung similarity ke tiap embedding user
            for emb in embeddings:
                score = cosine_similarity(target_emb, emb)

                if score > best_score:
                    best_score = score
                    best_user = peserta_id

        # ---------------------------- #
        # Tidak ada kecocokan sama sekali
        # ---------------------------- #
        if best_user is None:
            return {"success": False, "message": "Tidak ada data embedding"}

        # ---------------------------- #
        # Load metadata user
        # ---------------------------- #
        meta_path = os.path.join(META_DIR, f"{best_user}.json")
        name = None
        if os.path.exists(meta_path):
            with open(meta_path, "r", encoding="utf-8") as f:
                meta = json.load(f)
                name = meta.get("name", best_user)

        # ---------------------------- #
        # Threshold Recognition
        # ---------------------------- #
        # InsightFace standard threshold: 0.3 - 0.5 (cosine)
        THRESHOLD = 0.45

        if best_score < THRESHOLD:
            return {
                "success": False,
                "message": "Wajah tidak cocok",
                "confidence": float(best_score)
            }

        # ---------------------------- #
        # Return hasil
        # ---------------------------- #
        return {
            "success": True,
            "peserta_id": int(best_user),
            "name": name,
            "confidence": float(best_score)
        }

    except Exception as e:
        raise HTTPException(
            status_code=500,
            detail=f"Error server: {str(e)}"
        )
