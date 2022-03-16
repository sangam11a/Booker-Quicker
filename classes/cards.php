<link rel="stylesheet" href="../css/cards.css">
<?php
function cards_own($image,$name,$specialization){
   echo ' <div class="card-container Grid--3">';
       echo ' <img class="round" src="'.$image.'" alt="image-not-found" style="height:150px;width:150px;" />';
       echo " <h3>Name:$name<p>Specialization :$specialization</p></h3>";
        // <h6>New York</h6>
        // echo "";
       echo ' <div class="buttons">
            <button class="primary">
                Book Appointment
            </button>
        </div>';
        // <div class="skills">
        //     <h6>Skills</h6>
        //     <ul>
        //         <li>UI / UX</li>
        //         <li>Front End Development</li>
        //         <li>HTML</li>
        //         <li>CSS</li>
        //         <li>JavaScript</li>
        //         <li>React</li>
        //         <li>Node</li>
        //     </ul>
        // </div>
    echo '</div>';

}
?>