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
    }else if(d > 20){
        delay = 20;    
    }else{ 
        delay = d;
    }
    if(on == true){
        t.detach();
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
