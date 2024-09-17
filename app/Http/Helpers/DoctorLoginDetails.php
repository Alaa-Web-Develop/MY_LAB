<?php
namespace App\Http\Helpers;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DoctorLoginDetails extends Mailable
{
    use Queueable, SerializesModels;

    public $doctor;
    // public $password;
    public function __construct($created_doctor)
    {
        $this->doctor =$created_doctor;
        // $this->password =$password;
    }
    public function build()
    {
        return $this->subject('Mylab Application')->view('emails.doctor_login_details')->with([
            'doctorName'=>$this->doctor->name,
            'email'=>$this->doctor->email,
            'password'=>$this->doctor->random_number,
            'Approval_status'=>$this->doctor->Approval_Status
        ]);
    }
}