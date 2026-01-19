import os
import shutil

# path folder dataset
paths = [
    "dataset/embeddings",
    "dataset/meta"
]

for p in paths:
    for f in os.listdir(p):
        path_file = os.path.join(p, f)
        if os.path.isfile(path_file):
            os.remove(path_file)
        else:
            shutil.rmtree(path_file)

print("Semua embedding & metadata berhasil dihapus.")
