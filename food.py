import pygame
from PIL import Image, ImageDraw

# --- constants ---

BLACK = (  0,   0,   0)
WHITE = (255, 255, 255)
BLUE  = (  0,   0, 255)
GREEN = (  0, 255,   0)
RED   = (255,   0,   0)
GREY  = (128, 128, 128)

#PI = 3.1415

# --- main ----

pygame.init()
screen = pygame.display.set_mode((800,600))

# - generate PIL image with transparent background -

pil_size = 300

pil_image = Image.new("RGBA", (pil_size, pil_size))
pil_draw = ImageDraw.Draw(pil_image)
#pil_draw.arc((0, 0, pil_size-1, pil_size-1), 0, 270, fill=RED)
pil_draw.pieslice((0, 0, pil_size-1, pil_size-1), 330, 0, fill=GREY)

# - convert into PyGame image -

mode = pil_image.mode
size = pil_image.size
data = pil_image.tobytes()

image = pygame.image.fromstring(data, size, mode)