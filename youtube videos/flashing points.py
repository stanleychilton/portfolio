import pygame

pygame.init()

black = (0, 0, 0)
white = (255,255,255)
blue = (0, 0,255)
red = (200, 0, 0)
light_red = (255,0,0)
green = (0, 170, 0)
light_green = (0,255,0)
orange = (255,165,0)
grey = (128,128,128)

tinyfont = pygame.font.SysFont("comicsansms", 15)
smallfont = pygame.font.SysFont("comicsansms", 25)
medfont = pygame.font.SysFont("comicsansms", 50)
largefont = pygame.font.SysFont("comicsansms", 80)
superlargefont = pygame.font.SysFont("comicsansms", 185)

display_width = 1050
display_height = 500

size=[display_width,display_height]
screen=pygame.display.set_mode(size)

clock = pygame.time.Clock()
FPS = 1

running = True

count = 1
while running:
    while True:
        if count == 1:
            bottom_circle = green
            middle_circle = grey
            top_circle = grey
        elif count == 2:
            bottom_circle = grey
            middle_circle = orange
            top_circle = grey
        elif count == 3:
            bottom_circle = grey
            middle_circle = grey
            top_circle = red
            count = 0

        count += 1


        pygame.draw.circle(screen, top_circle, (75,100), 50, 10)
        pygame.draw.circle(screen, middle_circle, (75,200), 50, 10)
        pygame.draw.circle(screen, bottom_circle, (75,300), 50, 10)

        pygame.display.flip()
        clock.tick(FPS)
