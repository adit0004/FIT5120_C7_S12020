<div class="container">
    <div class="row" style="height:100%;">
        <div class="col-12 col-md-6 p-5">
            <div id="q1">
                <h1 class='text-center'>Know your own Health</h1>
                <p>If Australians were 100 people, represented here with 100 dots, you can see where you would lie depending on the answers to the following questions. These questions will help you better understand your health situation.</p>
                <p class="text-muted"><strong>Note: </strong>These details are <strong>not sent to any server or shared with anyone</strong>. They stay on your device for your privacy. If you are not comfortable answering these questions, please view <a href="<?php echo site_url(['general', 'showCharts']); ?>">the health facts for everyone.</a></p>
                <p>Before we begin, please let us know your age group:</p>
                <select id="age-bracket" class="form-control">
                    <option value="18to24">18 to 24 years</option>
                    <option value="25to34">25 to 34 years</option>
                    <option value="35to44">35 to 44 years</option>
                    <option value="25to34">45 to 54 years</option>
                    <option value="25to34">55 to 64 years</option>
                    <option value="25to34">65 to 74 years</option>
                    <option value="75toabove">75 years and above</option>
                </select>
                <button class="btn btn-primary mt-3" id="processAgeButton">Continue &rarr;</button>
            </div>
            <div id="q2">
                <h1>Physical activity guidelines for Australians</h1>
                    <ul>
                        <li>150 to 300 minutes (2 &frac12; to 5 hours) of moderate-intensity physical activity, or </li>
                        <li>75 to 150 minutes (1 &frac14; to 2 &frac12; hours) of vigorous-intensity physical activity, or</li>
                        <li>an equivalent combination of both moderate and vigorous activities, each week.</li>
                    </ul>
                    <p class="mt-2">
                        For more details, please visit <a href="https://www1.health.gov.au/internet/main/publishing.nsf/Content/health-pubhlth-strateg-phys-act-guidelines">this link.</a>
                    </p>
                    <p class="mt-2">Do you meet recommended guidelines for physical activity last week?</p>
                    <button class="btn btn-outline-success mt-3" id="processMetGuidelinesYes">Yes <i class="fa fa-check"></i></button>
                    <button class="btn btn-outline-primary mt-3" id="processMetGuidelinesNo">No <i class="fa fa-times"></i></button>
                    <button class="btn btn-outline-danger mt-3" id="skipAge">Skip Question <i class="fa fa-forward"></i></button>
            </div>
            <div id="q2yes">
                <h1>You are doing great!</h2>
                    <p>You are among the <span id="metGuidelinesPercentage"></span>% of people meeting the guidelines! Continue meeting the guidelines for physical activity for a healthy life</p>
                    <a href="<?php echo site_url(['general', 'showCharts']); ?>" class="btn btn-sm btn-outline-primary">All Health Statistics</a>
                    <a href="<?php echo site_url(['spaces', 'showSpaces']); ?>" class="btn btn-sm btn-outline-primary">Explore the Outdoors</a>
                    <a href="<?php echo site_url(['events', 'showEvents']); ?>" class="btn btn-sm btn-outline-primary">Explore Events Around</a>
                    <button class="btn btn-primary d-block mt-3 moveToBmi">Continue &rarr;</button>
            </div>
            <div id="q2no">
                <h1>You can do wonders for your health by exercising!</h2>
                    <p>You are among the <span id="didNotMeet"></span>% of people not meeting the guidelines. You can explore options to explore open spaces nearby and get started with a healthier way of living</p>
                    <a href="<?php echo site_url(['general', 'showCharts']); ?>" class="btn btn-sm btn-outline-primary">All Health Statistics</a>
                    <a href="<?php echo site_url(['spaces', 'showSpaces']); ?>" class="btn btn-sm btn-outline-primary">Explore the Outdoors</a>
                    <a href="<?php echo site_url(['events', 'showEvents']); ?>" class="btn btn-sm btn-outline-primary">Explore Events Around</a>
                    <button class="btn btn-primary d-block mt-3 moveToBmi">Continue &rarr;</button>
            </div>
            <div id="q3">
                <h1>Check your BMI to know more!</h1>
                <div class="form-group">
                    <label for="enterHeight">Please enter your height in centimeters:</label>
                    <div class="input-group">
                        <input type="number" name="height" id="enterHeight" class="form-control" step="1" min="50" max="251">
                        <div class="input-group-append">
                            <span class="input-group-text">cm</span>
                        </div>
                        <div class='invalid-feedback'>Please enter your height!</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="enterWeight">Please enter your weight in kilograms:</label>
                    <div class="input-group">
                        <input type="number" name="weight" id="enterWeight" class="form-control" step="0.1" min="2.1" max="635">
                        <div class="input-group-append">
                            <span class="input-group-text">kg</span>
                        </div>
                        <div class='invalid-feedback'>Please enter your weight!</div>
                    </div>
                </div>
                <button class="btn btn-primary mt-3" id="processBmi">Calculate!</button>
                <button class="btn btn-outline-danger mt-3 moveToLongTermIssues" id="skipBmi">Skip Question<i class="fa fa-forward"></i></button>
                <p class="mt-3 larger-text" id="bmiCalculated">Your BMI is considered: <span id="bmiResult"></span></p>
                <p class="mt-3" id="bmiMessage"></p>
                <div id="bmiButtons">
                    <a href="<?php echo site_url(['general', 'showCharts']); ?>" class="btn btn-sm btn-outline-primary">All Health Statistics</a>
                    <a href="<?php echo site_url(['spaces', 'showSpaces']); ?>" class="btn btn-sm btn-outline-primary">Explore the Outdoors</a>
                    <a href="<?php echo site_url(['events', 'showEvents']); ?>" class="btn btn-sm btn-outline-primary">Explore Events Around</a>
                </div>
                <div id="bmiContinue">
                    <button class="btn btn-primary d-block mt-3 moveToLongTermIssues">Continue &rarr;</button>
                </div>
            </div>
            <div id="q4">
                <h1>Long-term health issues</h1>
                <p>Would you like to know depending on your BMI, where you stand against other Australians based on long term health issues?</p>
                <select id="longTermHealthIssues" class="form-control">
                    <option value="arthritis">Arthritis</option>
                    <option value="asthama">Asthma</option>
                    <option value="backProblems">Back Problems</option>
                    <option value="cancer">Cancer</option>
                    <option value="copd">Chronic Obstructive Pulmonary Disease</option>
                    <option value="diabetes">Diabetes</option>
                    <option value="hayfever">Hayfever</option>
                    <option value="heartstrokevascular">Heart Stroke / Vascular Diseases</option>
                    <option value="hypertension">Hypertension</option>
                    <option value="kidneyissue">Kidney Issues</option>
                    <option value="mentalbehavioural">Mental and Behavioural Issues</option>
                    <option value="osteoporosis">Osteoporosis</option>
                </select>
                <p class="mt-3">Healthy lifestyle with moderate physical activity is always the way to go and EldVisor might be able to help you to explore places and events nearby to maintain a physically active lifestyle.</p>
                <a href="<?php echo site_url(['general', 'showCharts']); ?>" class="btn btn-sm btn-outline-primary">All Health Statistics</a>
                <a href="<?php echo site_url(['spaces', 'showSpaces']); ?>" class="btn btn-sm btn-outline-primary">Explore the Outdoors</a>
                <a href="<?php echo site_url(['events', 'showEvents']); ?>" class="btn btn-sm btn-outline-primary">Explore Events Around</a>
                <button class="btn btn-primary mt-3" id="continueFromLongTerm">Continue &rarr;</button>
            </div>
            <div id="q5">
                <h1>Let's get a bit cheeky</h1>
                <p class="mt-3">Alcohol consumption guidelines for Australian adults - </p>
                <p>If you’re a healthy adult:</p>
                <p>Guidelines -To reduce the risk of harm from alcohol-related disease or injury for healthy men and women, drink no more than 10 standard drinks per week and no more than 4 standard drinks on any one day.</p>
                <p>A standard drink contains 10g of alcohol. Many drinks have more than 1 standard drink in them. Check the label on your bottle or container to see how many standard drinks are in it.</p>
                <p class="mt-3">Which category do you fall under?</p>
                <select id="alcoholConsumption" class="form-control">
                    <option value="neverConsumedAlcohol">Never Consumed Alcohol</option>
                    <option value="12OrMoreMonths">Consumed Alchol 12 or more months ago</option>
                    <option value="notInLastWeekButUnder12Months">Did not consume alcohol last week but did less than 12 months ago</option>
                    <option value="didNotExceedGuidelines">Alcohol Consumption in the last week - Did not exceed guidelines</option>
                    <option value="exceededGuidelines">Alcohol Consumption in the last week - Exceeded guidelines</option>
                </select>
                <button class="btn btn-outline-primary" id="compareAlcohol">Compare</button>
                <p class="my-2" id="alcoholPercentage"></p>
                <p class="my-2">For some of us, alcohol may become hindrance to healthy lifestyle. EldVisor might be able to help you to explore places and events nearby to maintain a physically active lifestyle.</p>
                <a href="<?php echo site_url(['general', 'showCharts']); ?>" class="btn btn-sm btn-outline-primary">All Health Statistics</a>
                <a href="<?php echo site_url(['spaces', 'showSpaces']); ?>" class="btn btn-sm btn-outline-primary">Explore the Outdoors</a>
                <a href="<?php echo site_url(['events', 'showEvents']); ?>" class="btn btn-sm btn-outline-primary">Explore Events Around</a>
                
            </div>
        </div>
        <div class="col-12 col-md-6 p-0 bg-primary visualizationContainer" style="height:100%;">
            <svg width="500" height="500"></svg>
        </div>
    </div>
</div>

</div>