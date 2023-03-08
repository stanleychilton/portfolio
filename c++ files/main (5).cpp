//-- Stepper class using DigitalOut
#include "mbed.h"
#include <stdio.h>
DigitalIn button(PC_13);
RawSerial pc(PA_2, PA_3);


class Stepper
{
    
private:
 BusOut stepperMagnets;
 int delay; //-- delay between switching magnets (in ms)
 int direction;
 bool on;
 Ticker t;

public:
 Stepper(PinName PC_0, PinName PC_1, PinName PC_2, PinName PC_3, int d): stepperMagnets (PC_0, PC_1, PC_2, PC_3){
     direction = 1;
     on = false;
     delay = 4;
     }
 void toggleDirection(void);
 void setDelay(int);
 void toggleOn(void);   
 void run(void);
 void stop(void);
};

void Stepper::toggleDirection(void)
  {
    direction = direction * 3;
    //if(direction == 1)
//        direction = 3;
//    else direction = 1;  
    }

void Stepper::setDelay(int d){
    if (d < 4){
        delay = 4;
    }else{ 
        delay = d;
    }
    if(on == true){
        t.attach_us(callback(this, &Stepper::run), 1000*delay);
        }
    }

void Stepper::toggleOn(void){
     on = !on;
     if(on){
         t.attach_us(callback(this, &Stepper::run), 1000*delay);\
     }else{
         stop();
         t.detach();
        }
     }

void Stepper::run(void)
{
 static int currentMagnet = 0;
 stepperMagnets = (1 << currentMagnet);
 currentMagnet = (currentMagnet + direction)%4;
}
void Stepper::stop(void)
{
 stepperMagnets = 0; 
}
int main()
{
    Stepper myStepper(PC_0, PC_1, PC_2, PC_3, 10);
    while(1)
    {
        
        bool finished = false;
        int size = 0;
        char str[50];
        while(!finished)
        {
            char com = pc.getc();
            pc.putc(com);
            if(com == 13)
            {
                str[size++] = com;
                finished = true;
            }else str[size++] = com;
        }
        if(str[0] == 's')
        {
            myStepper.toggleOn();
        }else if(str[0] == 't')
        {
            myStepper.toggleDirection();
        }else if(str[0] == 'd')
        {
            if(str[3] != 13)
            {
                int x = str[2];
                int y = str[3];
                int n=(10*x)+y;
                myStepper.setDelay(n);
            }else
            {
                int n = str[2];
                myStepper.setDelay(n);
            }
        }
    }
}

