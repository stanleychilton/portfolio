import pygame
import math

class Player:

    ## initiales the player model will need to add all database entries here once database is setup
    def __init__(self, game_x, game_y, width, height, color, xp, hp, cur_hp):
        self.game_x = game_x
        self.game_y = game_y
        self.x = 0
        self.y = 0
        self.width = width
        self.height = height
        self.color = color
        self.rect = (self.x, self.y, width, height)
        self.xp = xp
        self.levels = self.set_levels(xp)
        self.xp_to_level = self.set_to_level(xp)
        self.vel = 1
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


    def output_as_text(self):
        print(""" woodcutting xp """+
              str(self.xp[0])+ " "+
              str(self.levels[0])+ """ """)

