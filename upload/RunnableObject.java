import java.util.Random;
import java.util.concurrent.locks.Condition;
import java.util.concurrent.locks.Lock;
import javax.swing.JLabel;
import javax.swing.SwingUtilities;
import java.awt.Color;

public class RunnableObject implements Runnable
{
   // for random letters
   private static Random generator = new Random();
   private Lock lockObject; // application lock;
   // used to suspend and resume thread
   private Condition suspend;        
   //true if thread suspended
   private boolean suspended = false;         
   private JLabel output; // JLabel for output
   public RunnableObject( Lock theLock, JLabel label )
   {
	// store the Lock for the application	   
     lockObject = theLock;  
     // create new Condition
     suspend = lockObject.newCondition();
     output = label; // store JLabel for outputting character
   } // end RunnableObject constructor

   // place random characters in GUI
   public void run()                
   {
      // get name of executing thread                            
      final String threadName = Thread.currentThread().getName();
      while ( true ) // infinite loop; will be terminated from outside
      {
        try
        {
          // sleep for up to 1 second
          Thread.sleep( generator.nextInt( 1000 ) );
          lockObject.lock(); // obtain the lock       
          try
          {
             while ( suspended ) // loop until not suspended
             {
               suspend.await(); // suspend thread execution
             } // end while
          } // end try
          finally
          {
             lockObject.unlock(); // unlock the lock
          } // end finally
        } // end try
        // if thread interrupted during wait/sleep
        catch ( InterruptedException exception )
        {
          exception.printStackTrace(); // print stack trace
        } // end catch

        // display character on corresponding JLabel
        SwingUtilities.invokeLater(                 
        new Runnable()                           
        {
            // pick random character and display it
            public void run()
            {
               // select random uppercase letter
               char displayChar =
                ( char ) ( generator.nextInt( 26 ) + 65 );
               // output character in JLabel
                output.setText( threadName + ": " + displayChar );
            } // end method run                   
         } // end inner class                     
         ); // end call to SwingUtilities.invokeLater
       } // end while
    } // end method run

    // change the suspended/running state
    public void toggle()
    {
      suspended = !suspended; // toggle boolean controlling state

     // change label color on suspend/resume
      output.setBackground( suspended ? Color.RED : Color.GREEN );
      lockObject.lock(); // obtain lock
      try
      {
        if ( !suspended ) // if thread resumed
        {
          suspend.signal(); // resume thread
        } // end if
      } // end try
      finally
      {
        lockObject.unlock(); // release lock
      } // end finally
   } // end method toggle
} // end class RunnableObject


