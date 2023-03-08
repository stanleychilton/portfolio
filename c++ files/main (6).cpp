//-- Stepper class using DigitalOut
#include "mbed.h"
#include <string>
#include <stdio.h>
#include <string.h>
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
     on = true;
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
    if(direction == 1)
        direction = 3;
    else direction = 1;  
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
     if(on == true){
         on = false;
         t.attach_us(callback(this, &Stepper::run), 1000*delay);
     }else{
         on = true;
         t.detach();
         stop();
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
 char com;
 std::string int2;
 Stepper myStepper(PC_0, PC_1, PC_2, PC_3, 10);
 while (1)
 {
 if (pc.readable())
 {
 if(pc.getc() == 13){
     }else{
     pc.puts("\ncommand: ");
     com = pc.getc();
     pc.putc(com);
     }
 
 }
 if (com == 's'){
     if(pc.getc() == 13){
     myStepper.toggleOn();
     com = '0';
     }
 }else if (com == 't'){
     if(pc.getc() == 13){
     myStepper.toggleDirection();
     com = '0';
     }
 }else if (com == 'd'){

            int x = (int)pc.getc();
            int y = (int)pc.getc();
            if(y != 13){
                int n=(10*x)+y;
                myStepper.setDelay(n);
            }else
            {
                int n = x;
                myStepper.setDelay(n);
         }
         }
         }
     }
 

