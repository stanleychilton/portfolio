#include "mbed.h"

DigitalOut GreenLED(PA_5);
DigitalOut blueLED(PA_7);

int main() {
    while(1) {
        GreenLED = 1; // LED is ON
        blueLED = 0; // LED is off
        wait(1); // 200 ms
        GreenLED = 0; // LED is OFF
        blueLED = 1; // LED is on
        wait(0.5); // 1 sec
    }
}
