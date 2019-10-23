import pygame, random

pygame.init()

white = (255,255,255)
black = (0,0,0)

tinyfont = pygame.font.SysFont("comicsansms", 15)
smallfont = pygame.font.SysFont("comicsansms", 25)
medfont = pygame.font.SysFont("BritannicBold", 50)
largefont = pygame.font.SysFont("comicsansms", 80)

screen_size = (1000, 500)

screen = pygame.display.set_mode(screen_size)
pygame.display.set_caption("Stan's painter")
screen.fill(white)

pygame.display.flip()

clock = pygame.time.Clock()
fps = 60



def create_map():
    cur_map = []
    for i in range(9):
        mapline = []
        for x in range(15):
            mapline.append(0)
        cur_map.append(mapline)
    x_pos = 0
    y_pos = len(cur_map)//2
    straight = 0
    while x_pos != 15:

        cur_map[y_pos][x_pos] = 1
        movechance = random.randrange(1,4)

        if movechance == 1:
            movement = random.randrange(1,4)
            if movement == 1 and y_pos != len(cur_map)-1:
                if cur_map[y_pos+1][x_pos] != 1:
                    y_pos += 1
            elif movement == 2 and y_pos != 0:
                if cur_map[y_pos-1][x_pos] != 1:
                    y_pos -= 1
            elif movement == 3:
                x_pos += 1
    for k in cur_map:
        print(k)




create_map()