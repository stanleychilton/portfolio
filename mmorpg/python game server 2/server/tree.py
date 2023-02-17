import pygame

class tree:
    def __init__(self, x, y, height, width, color):
        self.x = x
        self.y = y
        self.height = height
        self.width = width
        self.color = color
        self.tree_rect = pygame.Rect(x, y, width, height)
        self.state = True
        self.cut_time = 0

    def draw(self, win, x, y):
        #calculation used to move the tree depending on the players game position
        screen_x, screen_y = win.get_size()
        init_x = (screen_x / 2) - (self.width / 2)
        init_y = (screen_y / 2) - (self.height / 2)
        draw_x = init_x + (self.x - x)
        draw_y = init_y + (self.y - y)
        self.tree_rect = (draw_x, draw_y, self.width, self.height)
        if self.state == False:
            pygame.draw.rect(win, self.color, self.tree_rect)
        else:
            pygame.draw.rect(win, self.color, self.tree_rect)

    def cut_tree(self):
        self.state = False



