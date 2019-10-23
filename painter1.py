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
pen_type = "line"
pen_colour = black

tinyfont = pygame.font.SysFont("comicsansms", 15)
smallfont = pygame.font.SysFont("comicsansms", 25)
medfont = pygame.font.SysFont("comicsansms", 50)
largefont = pygame.font.SysFont("comicsansms", 80)

screen_size = (1000, 800)
colourchart = [red, green, blue, black, white, orange, grey, pink, yellow]
colchart_light = [light_red, light_green, light_blue, black, white, light_orange, grey, light_pink, light_yellow]

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

points_list = []
lines_list = []

colour = [0,0,0]

fill_col = white


def button(text, x, y, width, height, inactive_colour, active_colour, action = None):
    global pen_colour, pensize, lines_list, fill_col, pen_type
    cur = pygame.mouse.get_pos()
    click = pygame.mouse.get_pressed()
    if x + width > cur[0] > x and y + height > cur[1] > y:
        pygame.draw.rect(screen, active_colour, (x,y,width,height))
        if click[0] == 1 and action != None:
            if action == "quit":
                pygame.quit()
                quit()
            elif action == "wipe":
                lines_list = []
            elif action == "+":
                if pensize < 15:
                    pensize += 1
            elif action == "-":
                if pensize > 2:
                    pensize -= 1
            elif action == "undo":
                if lines_list != []:
                    del lines_list[-1]
            elif action == "fill":
                lines_list.append(["fill", pen_colour])
            elif action != None and action != "quit":
                pen_colour = action
    else:
        pygame.draw.rect(screen, inactive_colour, (x,y,width,height))
    text_to_button(text,black,x,y,width,height)

def button2(text, x, y, width, height, inactive_colour, active_colour, action = None):
    global pen_colour, pensize, lines_list, fill_col, pen_type
    cur = pygame.mouse.get_pos()
    click = pygame.mouse.get_pressed()
    if x + width > cur[0] > x and y + height > cur[1] > y:
        pygame.draw.rect(screen, active_colour, (x,y,width,height))
        if click[0] == 1 and action != None:
            if action != None:
                pen_type = action
    else:
        pygame.draw.rect(screen, inactive_colour, (x,y,width,height))
    text_to_button(text,black,x,y,width,height)



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


def text_objects(text, colour, size):
    if size == "tiny":
        textsurface = tinyfont.render(text, True, colour)
    elif size == "small":
        textsurface = smallfont.render(text, True, colour)
    elif size == "med":
        textsurface = medfont.render(text, True, colour)
    elif size == "large":
        textsurface = largefont.render(text, True, colour)
    return textsurface, textsurface.get_rect()


def message_to_screen(msg, colour, x_displace = 0, y_displace = 0, size = "small"):
    textSurf, textRect = text_objects(msg, colour, size)
    textRect = x_displace, y_displace
    screen.blit(textSurf,textRect)


def text_to_button(msg,colour,buttonx, buttony, buttonwidth, buttonhieght, size="small"):
    textSurf, textRect = text_objects(msg, colour, size)
    textRect.center = ((buttonx+(buttonwidth/2)), buttony+(buttonhieght/2))
    screen.blit(textSurf, textRect)


while running:


    pygame.draw.rect(screen, grey, (100, 0, 900, 800), 1)
    pygame.draw.rect(screen, white, (0, 0, 100, 800))
    pygame.draw.rect(screen, white, (100, 0, 900, 800))

    for line in lines_list:
        if line[0] == "fill":
            pygame.draw.rect(screen, line[1], (100, 0, 900, 800))

    pygame.draw.rect(screen, grey, (100, 0, 900, 800), 1)

    for lines in lines_list:
        if lines[0] == "line":
            pygame.draw.lines(screen, lines[2], False, lines[3], lines[1])
        elif lines[0] == "close":
            for points in lines[3]:
                pygame.draw.lines(screen, lines[2], True, (lines[3][0],points), lines[1])
                pygame.draw.lines(screen, lines[2], False, lines[3], lines[1])
        elif lines[0] == "squ":
            pygame.draw.rect(screen, lines[2], (lines[3][0], (lines[3][-1][0]-lines[3][0][0],lines[3][-1][1]-lines[3][0][1])), lines[1])
                

    pos = pygame.mouse.get_pos()
    click = pygame.mouse.get_pressed()


    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False


        if event.type == pygame.KEYDOWN:
            keys = pygame.key.get_pressed()
            if keys[pygame.K_COMMA]:
                if pensize > 2:
                    pensize -= 1
            if keys[pygame.K_PERIOD]:
                if pensize < 15:
                    pensize += 1
            if keys[pygame.K_LCTRL] and keys[pygame.K_z] and lines_list != []:
                    del lines_list[-1]


        if 100 < pos[0] < 1000 and 1 < pos[1] < 800:
            if click[0] == 1:
                position = (pos[0], pos[1])
                if len(points_list) == 0:
                    points_list.append((pos[0], pos[1]))
                if pen_type == "line" or pen_type == "close":
                    points_list.append(position)
                if pen_type == "line":
                    pygame.draw.lines(screen, pen_colour, False, points_list, pensize)
                    pygame.draw.circle(screen, pen_colour, position, pensize//3)
                elif pen_type == "close":
                    pygame.draw.lines(screen, pen_colour, True, points_list, pensize)
                elif pen_type == "squ":
                    pygame.draw.rect(screen, pen_colour, (points_list[0],(pos[0]-points_list[0][0], pos[1]-points_list[0][1])), pensize)
        if click[0] == 0:
            save = False
            if points_list != []:
                if pen_type == "squ":
                    points_list.append((pos[0],pos[1]))
                lines_list.append([pen_type, pensize, pen_colour, points_list])
            points_list = []



        button("Clear", 10, 0, 75, but_size, white, grey, action="wipe")
        button("-", 10, 25, but_size, but_size, white, grey, action="-")
        button("+", 60, 25, but_size, but_size, white, grey, action="+")
        button("Undo", 10, 50, 75, but_size, white, grey, action="undo")

        button("Fill", 10, bar_y + (but_size * 5), 75, but_size, white, grey, action="fill")
        button2("line", 10, bar_y + (but_size * 6), 75, but_size, white, grey, action="line")
        button2("closed", 10, bar_y + (but_size * 7), 75, but_size, white, grey, action="close")
        button2("square", 10, bar_y + (but_size * 8), 75, but_size, white, grey, action="squ")




        col = 0
        for x in range(3):
            for i in range(3):
                button(None, 10 + (but_size * x), 90 + (but_size * i), but_size, but_size, colourchart[col],
                       colchart_light[col], action=colourchart[col])
                col += 1

        pygame.draw.rect(screen, white, (40, 25, 25, 25))




        button1(bar, bar_y, 75, 2, grey, grey, action="scroll1")
        button1(bar, bar_y + sep, 75, 2, grey, grey, action="scroll2")
        button1(bar, bar_y + sep*2, 75, 2, grey, grey, action="scroll3")
        pygame.draw.rect(screen, grey, [x_scroll1 - 5, bar_y - 12, 10, 24])
        pygame.draw.rect(screen, grey, [x_scroll2 - 5, (bar_y + sep) - 12, 10, 24])
        pygame.draw.rect(screen, grey, [x_scroll3 - 5, (bar_y + sep*2) - 12, 10, 24])


        red_scroll = (255 / 75) * (x_scroll1 - 10)
        green_scroll = (255 / 75) * (x_scroll2 - 10)
        blue_scroll = (255 / 75) * (x_scroll3 - 10)


        colour = (int(red_scroll), int(green_scroll), int(blue_scroll))


        for i in range(10, 85):
                col_calc = (255 / 85) * (i - 10)
                pygame.draw.rect(screen, (col_calc,0,0), [i, bar_y - 21, 1, 6])
                pygame.draw.rect(screen, (0,col_calc,0), [i, (bar_y + sep) - 21, 1, 6])
                pygame.draw.rect(screen, (0,0,col_calc), [i, (bar_y + sep*2) - 21, 1, 6])


        button("", bar,(bar_y+sep*3)-18, 75, but_size, colour, colour, action=colour)

        print(lines_list)

        message_to_screen(str(pensize), black, 38,26, "tiny")
        pygame.display.flip()
        clock.tick(fps)
