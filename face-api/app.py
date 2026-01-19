from fastapi import FastAPI
from routes.register import router as register_router
from routes.recognize import router as recognize_router
from routes.check import router as check_router

def create_app():
    app = FastAPI(
        title="Face Recognition Presensi API",
        version="1.0.0"
    )

    app.include_router(register_router, prefix="/api", tags=["Register"])
    app.include_router(recognize_router, prefix="/api", tags=["Recognize"])
    app.include_router(check_router, prefix="/api", tags=['Check'])

    return app

app = create_app()

# RUN:
# uvicorn app:app --host 0.0.0.0 --port 5000
