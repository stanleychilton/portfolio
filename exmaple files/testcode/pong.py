import pygame, random

pygame.init()

white = (255,255,255)
black = (0,0,0)


but_size = 25
pensize = 3

tinyfont = pygame.font.SysFont("comicsansms", 15)
smallfont = pygame.font.SysFont("comicsansms", 25)
medfont = pygame.font.SysFont("BritannicBold", 50)
largefont = pygame.font.SysFont("comicsansms", 80)

screen_size = (1000, 500)

screen = pygame.display.set_mode(screen_size)
pygame.display.set_caption("Stan's painter")


pygame.display.flip()

clock = pygame.time.Clock()
fps = 60

mid_width = 5

running = True
pen_colour = black

left_speed = 0
right_speed = 0

left_y = 250
left_x = 17
right_y = 250
right_x = 983
paddle_width = 15
paddle_speed = 10

ball_size = 25
ball_dir = random.randint(1,2)
if ball_dir == 1:
    ball_x_speed = random.randint(-8,-3)
    ball_y_speed = random.randint(-8,-3)
elif ball_dir == 2:
    ball_x_speed = random.randint(3,8)
    ball_y_speed = random.randint(3,8)
ball_x = 500
ball_y = 250

paddle_size = 75

left_score = 0
right_score = 0

def button(text, x, y, width, height, inactive_colour, active_colour, action = None):
    global pen_colour, pensize
    cur = pygame.mouse.get_pos()
    click = pygame.mouse.get_pressed()
    if x + width > cur[0] > x and y + height > cur[1] > y:
        pygame.draw.rect(screen, active_colour, (x,y,width,height))
        if click[0] == 1 and action != None:
            if action == "quit":
                pygame.quit()
                quit()
            elif action == "wipe":
                pygame.draw.rect(screen, white, (100, 0, 900, 800))
            elif action == "custom":
                pen_colour = active_colour
            elif action == "+":
                if pensize < 15:
                    pensize += 1
            elif action == "-":
                if pensize > 2:
                    pensize -= 1
            elif action != None and action != "quit":
                pen_colour = action
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

def reset():
    global ball_size, ball_x_speed, ball_y_speed, ball_x, ball_y
    ball_size = 25
    ball_dir = random.randint(1,2)
    if ball_dir == 1:
        ball_x_speed = random.randint(-8,-3)
        ball_y_speed = random.randint(-8,-3)
    elif ball_dir == 2:
        ball_x_speed = random.randint(3,8)
        ball_y_speed = random.randint(3,8)
    ball_x = 500
    ball_y = 250


while running:
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False
        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_s:
                left_speed = paddle_speed
            if event.key == pygame.K_w:
                left_speed = -paddle_speed
            if event.key == pygame.K_DOWN:
                right_speed = paddle_speed
            if event.key == pygame.K_UP:
                right_speed = -paddle_speed


        if event.type == pygame.KEYUP:
            if event.key == pygame.K_s and left_speed == paddle_speed:
                left_speed = 0
            elif event.key == pygame.K_w and left_speed == -paddle_speed:
                left_speed = 0
            if event.key == pygame.K_DOWN and right_speed == paddle_speed:
                right_speed = 0
            elif event.key == pygame.K_UP and right_speed == -paddle_speed:
                right_speed = 0
            elif event.key == pygame.K_r:
                reset()



    if left_y-(paddle_size/2) <= -1:
        left_y = 0+(paddle_size/2)
    if left_y+(paddle_size/2) >= 501:
        left_y = 500-(paddle_size/2)



    if right_y-(paddle_size/2) <= -1:
        right_y = 0+(paddle_size/2)
    if right_y+(paddle_size/2) >= 501:
        right_y = 500-(paddle_size/2)


    if ball_y+ball_size >= 500:
            ball_y_speed -= (ball_y_speed*2)
    elif ball_y <= 0:
            ball_y_speed += abs(ball_y_speed*2)

    if ball_x <= -5:
        right_score += 1
        reset()
    elif ball_x+ball_size >= 1000:
        left_score += 1
        reset()

    screen.fill(black)
    pygame.draw.rect(screen, white, (500-(mid_width/2), 0, mid_width, 500))

    pygame.draw.rect(screen, white, (left_x-(paddle_width/2), left_y-(paddle_size/2), paddle_width, paddle_size))
    pygame.draw.rect(screen, white, (right_x-(paddle_width/2), right_y-(paddle_size/2), paddle_width, paddle_size))

    pygame.draw.rect(screen, white, (ball_x, ball_y, ball_size, ball_size))

    message_to_screen(str(left_score), white, 425,20, "med")
    message_to_screen(str(right_score), white, 550, 20, "med")

    if 501 > right_y-(paddle_size/2) > -1:
        right_y += right_speed

    if 501 > left_y-(paddle_size/2) > -1:
        left_y += left_speed

    if left_y <= ball_y <= left_y+paddle_size and left_x <= ball_x <= left_x+paddle_width:
        ball_y_speed = (ball_y_speed*2)
        ball_x_speed += abs(ball_x_speed*2)
    if right_y <= ball_y <= right_y+(paddle_size) and right_x <= ball_x+ball_size <= right_x+paddle_width:
        ball_y_speed = (ball_y_speed*2)
        ball_x_speed -= (ball_x_speed*2)

    ball_x += ball_x_speed
    ball_y += ball_y_speed

    pygame.display.flip()
    clock.tick(fps)
