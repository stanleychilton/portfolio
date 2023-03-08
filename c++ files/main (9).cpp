//-- This program wipes the servo motor arm back and forth
#include "mbed.h"
PwmOut servo(PB_0);
DigitalIn button(PC_13);
int main(void)
{
     int direction = 0, pw = 1000; //-- 1 ms pulse width
     servo.period_us(20000); //-- 20 ms time period
     while (button.read());
     while (1)
     {
         servo.pulsewidth_us(pw);
         wait_us(40000); //-- wait for 40 ms to let the motor catch up
         if (direction == 0)
         {
             pw += 20; //-- increase pulse width by 20 us
             if (pw > 2000)
             {
                 pw = 2000;
                 direction = 1;
        }
    }
     else
    
     {
         pw -= 20; //-- decrease pulse width by 20 us
         if (pw < 1000)
         {
             pw = 1000;
             direction = 0;
            }  
        }
    }
}