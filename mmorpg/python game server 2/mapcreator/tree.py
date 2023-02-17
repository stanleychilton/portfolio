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

    def draw(self, win):
        if self.state == False:
            pygame.draw.rect(win, self.color, self.tree_rect)
        else:
            pygame.draw.rect(win, self.color, self.tree_rect)

    def cut_tree(self):
        self.state = False



