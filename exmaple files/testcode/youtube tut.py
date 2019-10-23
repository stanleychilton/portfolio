import pygame, random

pygame.init()

white = (255,255,255)
red = (255,0,0)
black = (0,0,0)

screen_size = (1000, 800)

screen = pygame.display.set_mode(screen_size)
pygame.display.set_caption("Gravity")
screen.fill(white)

pygame.display.flip()

clock = pygame.time.Clock()
fps = 120

running = True
speed = 9.81/fps
overall_speed = speed
pos = (random.randint(1,999), random.randint(1,700))
direction = "pos"
ball_size = 26
total = 0
effect = 1.5

while running:
    screen.fill(white)
    for event in pygame.event.get():
        if event.type == pygame.QUIT:
            running = False
        if event.type == pygame.KEYDOWN:
            if event.key == pygame.K_r:
                pos = (random.randint(1, 999), random.randint(1, 700))
                direction = "pos"
    if direction == "pos":
        ball_speed = speed + overall_speed
        overall_speed = ball_speed
        pos = (pos[0], round(pos[1] + overall_speed))
    elif direction == "neg":
        ball_speed = total - speed
        total = ball_speed
        pos = (pos[0], round(pos[1] - ball_speed))
    if pos[1] >= 700-ball_size and direction == "pos":
        pos = (pos[0], 700-ball_size-1)
        total = overall_speed#/effect
        overall_speed = 0
        direction = "neg"
    elif total <= 0 and direction == "neg":
        direction = "pos"
    pygame.draw.rect(screen, black, (0,700,1000,100))
    pygame.draw.circle(screen, red, pos, ball_size)

    pygame.display.flip()
    clock.tick(fps)