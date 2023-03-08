//-- Displays the distance in CM
#include "mbed.h"
PwmOut usTrig(PB_3);
DigitalIn usEcho(PB_5);
Timer t;
int main()
{
     float pulseWidth; //-- pulse width in uSec
     float distance; //-- distance in CM
    
     usTrig.period_us(100000);
     usTrig.pulsewidth_us(10);
     printf("Ultrasonic Sensor:\n");
     while(1)
     {
         //-- wait for Echo signal to go high
         while (! usEcho.read()); t.start();
         //-- wait for Echo signal to go low
         while (usEcho.read());
         t.stop();
        
         //printf("%d\n", t.read_us());
         pulseWidth = t.read_us();
         distance = (float)0.017*pulseWidth;
         printf("Distance [CM]: %5.2f", distance);
         printf("\n");
         t.reset();
         wait(1); //-- wait 1 second
     }
}