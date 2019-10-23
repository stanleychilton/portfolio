import string

import turtle #import the turtle module
wn = turtle.Screen()

my_turtle = turtle.Turtle()
my_turtle.speed(10)
my_turtle.setposition(0,0)
for x in range(0,20):
    for y in range(0,10,1):
        my_turtle.forward(y)
        my_turtle.right(y)
        for z in range(0,1,1):
            my_turtle.forward(z)
            my_turtle.left(z+45)
            alphalist = [x for x in string.ascii_lowercase]
            string = string.ascii_lowercase
            print(alphalist)
            betalist = []
            for x in alphalist:
                sum = 0
                for letter in string:
                    if x == letter: sum += 1
                if sum != 0:
                    print(x, sum)
                    betalist.append((x, sum))

                for x in range(0,2):
                    for entry in betalist:
                        my_turtle.write(entry[0])
                        my_turtle.penup()
                        my_turtle.left(90)
                        my_turtle.forward(50)
                        my_turtle.pendown()
                        for i in range(0,entry[1]):
                            my_turtle.forward(10)
                        my_turtle.penup()
                        dist = (10 * entry[1]) + 50
                        my_turtle.back(dist)
                        my_turtle.right(90)
                        my_turtle.forward(20)
                    my_turtle.right(5)
                    my_turtle.setposition(0,0)
                    my_turtle.left(45)

wn.exitonclick()