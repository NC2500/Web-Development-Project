import os

# Directory to scan for images
IMAGE_DIR = 'images/coffee'

# Allowed image extensions
IMAGE_EXTENSIONS = ('.jpg', '.jpeg', '.png', '.gif', '.webp', '.bmp', '.svg')

def list_images(directory):
    if not os.path.isdir(directory):
        print(f"Directory '{directory}' does not exist.")
        return

    print(f"{'File Name':40} | {'Full Path'}")
    print('-' * 80)

    for root, dirs, files in os.walk(directory):
        for filename in files:
            if filename.lower().endswith(IMAGE_EXTENSIONS):
                full_path = os.path.join(root, filename)
                print(f"{filename:40} | {full_path}")

if __name__ == "__main__":
    list_images(IMAGE_DIR)
