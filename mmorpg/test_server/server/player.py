import math
import pygame
from math import ceil

class Player:

    ## initiales the player model will need to add all database entries here once database is setup
    def __init__(self, game_x, game_y, width, height, color, xp, levels, xp_to_level, hp, cur_hp, inventory):
        self.game_x = game_x
        self.game_y = game_y
        self.x = 0
        self.y = 0
        self.width = width
        self.height = height
        self.color = color
        self.rect = (self.x, self.y, width, height)
        self.xp = xp
        self.levels = levels
        self.xp_to_level = xp_to_level
        self.vel = 1
        self.cur_hp = cur_hp
        self.hp = hp
        self.hp_length = 50
        self.inventory = inventory

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

    def set_woodcutting_xp(self, xp):
        x = 0
        self.xp[x] += xp
        self.check_levels(x)

    def check_levels(self, index):
        max_xp = int(self.xp_to_level[index])
        if self.xp[index] >= max_xp:
            self.levels[index] += 1
            if self.levels[index] == 1:
                self.xp_to_level[index] = int(max_xp + (max_xp *(1+(10/100))))
            else:
                self.xp_to_level[index] = max_xp + (math.floor(self.levels[index] + 300 * (2 ** (self.levels[index]/7))))/4


    def output(self):
        print(self.levels)
        print(self.xp_to_level)
        print(self.xp)

    def output_as_text(self):
        print(""" woodcutting xp """+
              str(self.xp[0])+ " "+
              str(self.levels[0])+ """ """)

    def save_data(self):
        return [self.game_x, self.game_y, self.width, self.height, self.color,self.hp,self.cur_hp]
