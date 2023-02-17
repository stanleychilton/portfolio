import pygame

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
