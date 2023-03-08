//-- Stepper class using DigitalOut
#include "mbed.h"
DigitalIn button(PC_13);
class Stepper
{
private:
 BusOut stepperMagnets;
 int delay; //-- delay between switching magnets (in ms)
 int direction;

public:
 Stepper(PinName PC_0, PinName PC_1, PinName PC_2, PinName PC_3, int d): stepperMagnets (PC_0, PC_1, PC_2, PC_3)
 {
 if (d < 4)
 delay = 4;
 else delay = d;
 }

 void run(void);
 void stop(void);
};
void Stepper::run(void)
{
 static int currentMagnet = 0;
 stepperMagnets = (1 << currentMagnet);
 currentMagnet = (currentMagnet + direction)%4;
 wait_ms(delay);
}
void Stepper::stop(void)
{
 //-- all the magnets turned off
 stepperMagnets = 0; 
}
int main()
{
 Stepper myStepper(PC_0, PC_1, PC_2, PC_3, 10);
 while (1)
 {
 if (!button.read()) //-- is the button pressed?
 {
 myStepper.run(); //-- run the motor
 }
 else //-- button is released
 myStepper.stop(); //-- stop the motor
 }
}