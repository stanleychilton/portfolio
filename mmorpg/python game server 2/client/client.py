import pygame
from pygame.locals import *
from network import network
from player import Player
import sys, os

os.environ['SDL_VIDEO_CENTERED'] = '1'

pygame.init()
flags = pygame.FULLSCREEN


info = pygame.display.Info() # You have to call this before pygame.display.set_mode()
screen_width,screen_height = info.current_w,info.current_h
width,height = screen_width,screen_height


win = pygame.display.set_mode((width, height), flags)

pygame.display.set_caption("New game")
n = network()

## redraws the content in the window using the player.draw function
def redrawwindow(win, player, player2, map, button):
    win.fill((255, 255, 255))
    player.draw(win)
    coords = player.fetchcoords()
    #print(player2)
    for i in player2:
        player2[i].draw(win)
    for i in map:
        i.draw(win, coords[0], coords[1])
    for i in button:
        i.draw(win)
    pygame.display.update()


def main(p_data, ui):
    run = True
    p = p_data
    p.set_center(win)
    clock = pygame.time.Clock()
    q_button = ((255, 0, 0), (0,0,50,50))
    action = ui

    while run:

        clock.tick(60)
        ##sends the player data and loads the incoming data
        p2 = n.send((1, p))
        map = n.send((2, 2))

        ## looks for a event of the player quitting
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                run = False
                pygame.quit()
            if event.type == MOUSEBUTTONDOWN:
                for i in action:
                    i.click(event)
                for i in map:
                    player_out = i.click(event)
                    print("test:", player_out)

        ## looks for a player movement
        p.move()
        redrawwindow(win, p, p2, map, action)



def login():
    base_font = pygame.font.Font(None, 32)
    ##defining colors
    color_active = pygame.Color('lightskyblue3')
    color_passive = pygame.Color('gray15')
    ## setting the textboxes to passive (currently unselected)
    color_user = color_passive
    color_pass = color_passive
    ## sets the variables to nothing so username and pass can be entered
    username = ""
    password = ""
    ## setting the rectangles (where user click with be detected) to type into
    input_rect = pygame.Rect(200,200,140,32)
    password_rect = pygame.Rect(200,250,140,32)
    ## both false as neither of the textboxes are selected
    active_user = False
    active_pass = False
    clock = pygame.time.Clock()
    while True:
        for event in pygame.event.get():
            if event.type == pygame.QUIT:
                pygame.quit()
                sys.exit()
            ## checks for a click inside the textbox which ever is clicked is what you will be typing into
            if event.type == pygame.MOUSEBUTTONDOWN:
                if input_rect.collidepoint(event.pos):
                    active_user = True
                else:
                    active_user = False
                if password_rect.collidepoint(event.pos):
                    active_pass = True
                else:
                    active_pass = False

            ## checks for a key being pressed
            if event.type == pygame.KEYDOWN:
                if active_user:
                    ## if the key pressed is backspace will remove the last value
                    if event.key == pygame.K_BACKSPACE:
                        username = username[:-1]
                    ## if the key pressed is anything else will append it to the end of the string
                    else:
                        if event.key == pygame.K_RETURN:
                            active_user = False
                            active_pass = True
                        else:
                            username += event.unicode

                ## does the same as previous except for password
                if active_pass:
                    if event.key == pygame.K_BACKSPACE:
                        password = password[:-1]
                    else:
                        if event.key == pygame.K_RETURN and username != "" and password != "":
                            print(username, password)
                            p2 = n.send((username, password))
                            print(p2)
                            if p2[0] == 200:
                                print(p2[2])
                                main(p2[1], p2[2])
                                break
                            else:
                                print(p2[1])
                                pass
                        else:
                            if event.key == pygame.K_RETURN:
                                pass
                            else:
                                password += event.unicode



        win.fill((0, 0, 0))

        ## changes the color depending on whether the text box is active or not
        if active_user:
            color_user = color_active
        else:
            color_user = color_passive

        if active_pass:
            color_pass = color_active
        else:
            color_pass = color_passive

        ## draws all the items to the screen
        pygame.draw.rect(win, color_user, input_rect, 2)

        pygame.draw.rect(win, color_pass, password_rect, 2)

        text_surface = base_font.render(username,True,(255,255,255))
        win.blit(text_surface,(50,50))

        text_surface1 = base_font.render("*"*len(password), True, (255, 255, 255))
        win.blit(text_surface1, (0, 0))

        ## updates everything that was just drawn
        pygame.display.flip()
        clock.tick(60)


## this is just to be able to switch between login and main game page (needed for being able to code both while login isnt working)
login()
#main()


