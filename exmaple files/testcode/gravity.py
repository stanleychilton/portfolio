import pygame, random

pygame.init()

white = (255,255,255)
red = (255,0,0)
black = (0,0,0)
grey = (220,220,220)

screen_size = (1000, 800)

screen = pygame.display.set_mode(screen_size)
pygame.display.set_caption("Gravity")
screen.fill(white)

pygame.display.flip()

clock = pygame.time.Clock()
fps = 120

running = True
speed = 9.81/fps
y_speed = 0
overall_speed = speed
pos = (random.randint(1,999),random.randint(1,700))
direction = "pos"
ball_size = 26
total = 0
bar = 0
bar_y = 10
x_scroll1 = 500


def button1(x, y, width, height, inactive_colour, active_colour, action = None):
    global pen_colour, pensize, x_scroll1, x_scroll2, x_scroll3
    cur = pygame.mouse.get_pos()
    click = pygame.mouse.get_pressed()
    if x + width > cur[0] > x and y + height + 12 > cur[1] > y - 12:
        pygame.draw.rect(screen, active_colour, (x,y,width,height))
        if click[0] == 1 and action != None:
            if action == "scroll1":
                x_scroll1 = cur[0]
    else:
        pygame.draw.rect(screen, inactive_colour, (x,y,width,height))



while running:
    screen.fill(white)
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False
        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_r:
                pos = (random.randint(1,999),random.randint(1,700))  
    if direction == "pos":
        ball_speed = speed + overall_speed
        overall_speed = ball_speed
        pos = (pos[0]+(round(y_speed/100)), round(pos[1] + overall_speed))
    elif direction == "neg":
        ball_speed = total - speed
        total = ball_speed
        pos = (pos[0], round(pos[1] - ball_speed))
    if pos[1] >= 700-ball_size and direction == 'pos':
        pos = (pos[0], 700-ball_size-1)
        total = overall_speed/2
        overall_speed = 0
        direction = 'neg'
    elif total <= 0 and direction == "neg":
        direction = "pos"
    pygame.draw.rect(screen, black, (0, 700, 1000, 100))
    pygame.draw.circle(screen,red, pos, ball_size)
    button1(bar, bar_y, 1000, 2, grey, grey, action="scroll1")
    pygame.draw.rect(screen, grey, [x_scroll1 - 5, bar_y - 12, 10, 24])
    scroll = x_scroll1 - 500
    y_speed = scroll

    pygame.display.flip()
    clock.tick(fps)


