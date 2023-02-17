import pygame
from math import ceil

class Player:

    ## initiales the player model will need to add all database entries here once database is setup
    def __init__(self, game_x, game_y, width, height, color, hp, cur_hp):
        self.game_x = game_x
        self.game_y = game_y
        self.x = 0
        self.y = 0
        self.width = width
        self.height = height
        self.color = color
        self.rect = (self.x, self.y, width, height)
        self.vel = 3
        self.cur_hp = cur_hp
        self.hp = hp
        self.hp_length = 50

    ## this function is called from the client to draw the player to the screen also used from the recieved other players to draw them too
    ## here is probably where the 3d drawing of players will need to be written
    def draw(self, win):
        pygame.draw.rect(win, self.color, self.rect)
        hp = ceil(self.cur_hp / self.hp * self.hp_length)
        end_bar = (self.hp_length - hp)
        pygame.draw.rect(win, (255, 0, 0), (self.rect[0]+hp, self.rect[1]-15, end_bar, 10))
        pygame.draw.rect(win, (0, 255, 0), (self.rect[0], self.rect[1]-15, hp, 10))


    ## handles the movement of the player (the client can only handle the movement of the current player)
    def move(self):
        keys = pygame.key.get_pressed()
        if keys[pygame.K_LEFT]:
            self.game_x -= self.vel
        if keys[pygame.K_RIGHT]:
            self.game_x += self.vel

        if keys[pygame.K_UP]:
            self.game_y -= self.vel
        if keys[pygame.K_DOWN]:
            self.game_y += self.vel

        if keys[pygame.K_LSHIFT]:
            self.vel = 5
        elif self.vel==5:
            self.vel=3



        self.update()

    ## is called to update the current players position and sizing (size is not changable)
    def update(self):
        self.rect = (self.x, self.y, self.width, self.height)


    ## gets the players game coords for checking its position in regards to other map objects
    def fetchcoords(self):
        return(self.game_x, self.game_y)

    # ##sets the players coords when they leave the screen
    # def setcoords_x(self,x):
    #     self.x=x
    #
    # def setcoords_y(self,y):
    #     self.y=y

    def set_center(self, win):
        screen_x, screen_y = win.get_size()

        self.x = (screen_x/2)-(self.width/2)
        self.y = (screen_y / 2) - (self.height / 2)
        print(screen_x, screen_y)
        print(self.x, self.y)

    def save_data(self):
        return [self.game_x, self.game_y, self.width, self.height, self.color,self.hp,self.cur_hp]

    def send_to_client(self):
        return



