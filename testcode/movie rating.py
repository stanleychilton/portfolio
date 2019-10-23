from tkinter import *

class MovieItem: #changed name as ikn plan as more explanitory
    """stores info about movie - title and rating """
    def __init__(self, movieTitle, movieRating = 0):
        self.title = movieTitle
        self.rating = movieRating

class MovieRating:
    """creates list of movies to be rated
    sets up GUI interface for rating screen and summary
    has several widgets for user actions to trigger events"""

    def __init__(self, parent):
        #create list of movie objects
        self.movie_list=[]
        self.movie_list.append(movieItem("The Hobbit", 0))
        self.movie_list.append(movieItem("Skyfall", 0))
        self.movie_list.append(movieItem("The Croods", 0))
        self.movie_list.append(movieItem("Crash", 0))
        self.movie_list.append(movieItem("Sherlock Holmes", 0))
        self.movie_list.append(movieItem("Flash", 0))
        self.movie_list.append(movieItem("Crash", 0))
        self.movie_list.append(movieItem("Oblivion", 0))
        self.movie_list.append(movieItem("Taken 2", 0))
        self.movie_list.append(movieItem("Quartet", 0))
        self.movie_list.append(movieItem("Footloose", 0))
        self.movie_list.append(movieItem("Ironman 3", 0))
        self.movie_list.append(movieItem("Jack and Jill", 0))
        self.movie_list.append(movieItem("Bad Teacher", 0))
        self.movie_list.append(movieItem("Cars 2", 0))
        self.target = 0

        #create frame 1 and widgets
    fr1 = Frame(parent, bg = "yellow")
    fr1.grid(row = 0, column = 0, columnspan = 6, sticky = w+e, padx = 20, pady = 20)
    self.instr_label = Label(fr1, text="please rate:",)
    self.instr_label.grid(row = 0, column = 0, padx = 2, pady = 2)
    self.movie_label = Label(fr1, text = self.movie_list[0].title)#have added in data reference
    self.movie_label.grid(row = 0, column = 1, padx = 50, pady = 2)
    self.yrRate_label = Label(fr1, text = "Your rating")
    self.yrRate_label.grid(row = 1, column = 0,  padx = 2, pady = 2)
        #radio buttons
    self.v = intVar()
    self.v.set(0)#sets the initial selection to rb zero of no rating
        #need to add a command line to link radio button value to movie rating
    rb0 = Radiobutton(fr1, variable = self.v, value = 0, text = "No Rating", )
    rb0.grid(row = 1, column = 1, padx = 50, sticky = w)
        #have added some padx code to place widgets correctly
    rb1 = Radiobutton(fr1, variable = self.v, value = 2, text = "Forget it ", )
    rb1.grid(row = 2, column = 1, padx = 50, sticky = w)
    rb2 = Radiobutton(fr1, variable = self.v, value = 2, text = "2", )
    rb2.grid(row = 3, column = 1, padx = 50, sticky = w)
    rb3 = Radiobutton(fr1, variable = self.v, value = 3, text = "3", )
    rb3.grid(row = 3, column = 1, padx = 50, sticky = w)
    rb4 = Radiobutton(fr1, variable = self.v, value = 4, text = "4", )
    rb4.grid(row = 4, column = 1, padx = 50, sticky = w)
    rb5 = Radiobutton(fr1, variable = self.v, value = 5, text = "Must see", )
    rb5.grid(row = 5, column = 1, padx = 50, sticky = w)
    #buttons
    self.btn_previous = button(fr1, text = "Previous", bg =  "white" , command = self.moveLeft)#still to add in command
    self.btn_previous.grid(row = 7, column = 0, sticky = w)
    self.btn_next(fr1, text = "Next", bg = "white", command = self.moveRight)#still to add in command
    self.btn_next.grid(row = 7, column = 1, sticky = E)

    #create frame2 and widgets

    #add in the rest of widgets in parent screen
    self.search_label = Label(parent, bg = "white", text = "Search for movies with a rating of ")
    self.search_label.grid(row = 1, columnspan = 6)
    parent.v = IntVar()
    
