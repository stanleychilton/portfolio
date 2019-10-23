import pygame

pygame.init()

white = (255,255,255)
red = (255,0,0)
light_red = (220,0,0)
green = (0,220,0)
light_green = (0,255,0)
blue = (0,0,255)
light_blue = (0,0,220)
black = (0,0,0)
grey = (220,220,220)
orange = (229,160,11)
light_orange = (234,165,16)
pink = (231,62,238)
light_pink = (236,67,242)
yellow = (238,228,62)
light_yellow = (242,232,67)

but_size = 25
pensize = 3

tinyfont = pygame.font.SysFont("comicsansms", 15)
smallfont = pygame.font.SysFont("comicsansms", 25)
medfont = pygame.font.SysFont("comicsansms", 50)
largefont = pygame.font.SysFont("comicsansms", 80)

screen_size = (1000, 800)
colourchart = [red, green, blue, white, black, orange, grey, pink, yellow]
colchart_light = [light_red, light_green, light_blue, white, black, light_orange, grey, light_pink, light_yellow]

screen = pygame.display.set_mode(screen_size)
pygame.display.set_caption("Stan's painter")
screen.fill(white)

pygame.display.flip()

clock = pygame.time.Clock()
fps = 500

running = True
x_scroll1 = 10
x_scroll2 = 10
x_scroll3 = 10
bar = 10
bar_y = 200
sep = 35

colour = [0,0,0]

def button1(x, y, width, height, inactive_colour, active_colour, action = None):
    global pen_colour, pensize, x_scroll1, x_scroll2, x_scroll3
    cur = pygame.mouse.get_pos()
    click = pygame.mouse.get_pressed()
    if x + width > cur[0] > x and y + height + 12 > cur[1] > y - 12:
        pygame.draw.rect(screen, active_colour, (x,y,width,height))
        if click[0] == 1 and action != None:
            if action == "scroll1":
                x_scroll1 = cur[0]
            elif action == "scroll2":
                x_scroll2 = cur[0]
            elif action == "scroll3":
                x_scroll3 = cur[0]
    else:
        pygame.draw.rect(screen, inactive_colour, (x,y,width,height))

while running:
    pos = pygame.mouse.get_pos()
    click = pygame.mouse.get_pressed()
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False
    screen.fill(white)
    button1(bar, bar_y, 75, 2, grey, grey, action="scroll1")
    button1(bar, bar_y + sep, 75, 2, grey, grey, action="scroll2")
    button1(bar, bar_y + sep * 2, 75, 2, grey, grey, action="scroll3")
    pygame.draw.rect(screen, grey, [x_scroll1 - 5, bar_y - 12, 10, 24])
    pygame.draw.rect(screen, grey, [x_scroll2 - 5, (bar_y + sep) - 12, 10, 24])
    pygame.draw.rect(screen, grey, [x_scroll3 - 5, (bar_y + sep * 2) - 12, 10, 24])

    red_scroll = (255 / 75) * (x_scroll1 - 10)
    green_scroll = (255 / 75) * (x_scroll2 - 10)
    blue_scroll = (255 / 75) * (x_scroll3 - 10)

    colour = [int(red_scroll), int(green_scroll), int(blue_scroll)]

    pygame.draw.rect(screen, colour, [500, 500, 100, 100])

    for i in range(10, 85):
        col_calc = (255 / 85) * (i - 10)
        pygame.draw.rect(screen, (col_calc, 0, 0), [i, bar_y - 21, 1, 6])
        pygame.draw.rect(screen, (0, col_calc, 0), [i, (bar_y + sep) - 21, 1, 6])
        pygame.draw.rect(screen, (0, 0, col_calc), [i, (bar_y + sep * 2) - 21, 1, 6])

    pygame.display.flip()
    clock.tick(fps)
