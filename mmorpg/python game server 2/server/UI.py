import pygame


class ActionBar:
    def __init__(self, win):
        self.screen_x, self.screen_y = win.get_size()
        self.action_bar_color = (255,0,0)
        self.button_color = (0,255,0)
        self.action_bar_width = 100
        self.action_bar_height = 60
        self.action_bar_x = self.screen_x-self.action_bar_width
        self.action_bar_y = self.screen_y-self.action_bar_height
        self.action_bar_rect = pygame.Rect(self.action_bar_x,
                                           self.action_bar_y,
                                           self.action_bar_width,
                                           self.action_bar_height)
        self.inventory_button_rect = pygame.Rect()
        self.inventory = Button1(self.inventory_button_rect, self.button_color)


class Button1:
    def __init__(self, rect, color):
        self.rect = rect
        self.color = color


class QuitButton:
    def __init__(self):
        self.color = (255,0,0)
        self.small_button = (50, 50)
        self.quit_rect = pygame.Rect(0, 0, 50, 50)

    def draw(self, win):
        pygame.draw.rect(win, self.color, self.quit_rect)

    def click(self, event):
        x, y = pygame.mouse.get_pos()
        if event.type == pygame.MOUSEBUTTONDOWN:
            if pygame.mouse.get_pressed()[0]:
                if self.quit_rect.collidepoint(event.pos):
                    pygame.quit()
