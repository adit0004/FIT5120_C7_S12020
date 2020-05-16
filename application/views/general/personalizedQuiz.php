<div class="container">
     <div class="row" style="height:100%;">
         <div class="col-12 col-md-6 p-5">
             <h1 class='text-center'>Know your own Health</h1>
             <p>If Australians were 100 people, represented here with 100 dots, you can see where you would lie depending on the answers to the following questions. These questions will help you better understand your health situation.</p>
             <p class="text-muted"><strong>Note: </strong>These details are <strong>not sent to any server or shared with anyone</strong>. They stay on your device for your privacy. If you are not comfortable answering these questions, please view <a href="<?php echo site_url(['general','showCharts']);?>">the health facts for everyone.</a></p>
             <p>Before we begin, please let us know your age group:</p>
             <select id="age-bracket" class="form-control">
                 <option value="18to24">18 to 24 years</option>
                 <option value="25to34">25 to 34 years</option>
                 <option value="35to44">35 to 44 years</option>
                 <option value="25to34">45 to 54 years</option>
                 <option value="25to34">55 to 64 years</option>
                 <option value="25to34">65 to 74 years</option>
                 <option value="75andabove">75 years and above</option>
             </select>
             <button class="btn btn-outline-primary mt-3" onclick="processAgeGroup()">Continue &rarr;</button>
         </div>
         <div class="col-12 col-md-6 p-5 bg-primary visualizationContainer" style="height:100%;">
            <svg width="100%" height="100%"></svg>
         </div>
     </div>
 </div>

 </div>