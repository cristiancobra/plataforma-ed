<?php

namespace App\View\Components\Navmenu;

use Illuminate\View\Component;

class NavMenu extends Component {

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render() {
        $empresaDigital = \App\Models\Account::find(1);

        if (auth()->user() == true AND auth()->user()->account->logo) {
            $logo = auth()->user()->account->logo;
        } else {
            $logo = asset('images/logo-empresa-digital.png');
        }
// dd($empresaDigital);
        if(auth()->user() == true ? $lastJourney = \App\Models\Journey::myLastJourney() : $lastJourney = null);
        if(auth()->user() == true ? $openJourney = $openJourney = \App\Models\Journey::myOpenJourney() : $openJourney = null);
        if(auth()->user() == true ? $tasksEmergency = $tasksEmergency = \App\Models\Task::getTasksEmergency() : $tasksEmergency = null);
        if(auth()->user() == true ? $tasksEmergencyTotal = \App\Models\Task::countTasksEmergency() : $tasksEmergencyTotal = null);
        
//        if (auth()->user() == true) {
//            $lastJourney = \App\Models\Journey::myLastJourney();
//            $openJourney = \App\Models\Journey::myOpenJourney();
//            $tasksEmergency = \App\Models\Task::getTasksEmergency();
//            $tasksEmergencyTotal = \App\Models\Task::countTasksEmergency();
//        }

        return view('components.navmenu.nav-menu', compact([
            'logo',
            'lastJourney',
            'openJourney',
            'tasksEmergency',
            'tasksEmergencyTotal',
        ]));
    }

}
