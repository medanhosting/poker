<div class='popup' id='transfersHistory'>
    <div class='wrap'>
        <hgroup>
            <h2>Transfers history</h2>
            
        </hgroup>    
        <nav>
            <ul>
                <li><a href='#' id='incomesTab' class='active'>Incomes</a></li>
                <li><a href='#' id='outcomesTab'>Outcomes</a></li>
            </ul>
        </nav>
        <div class='spinner_big'></div>
        <table id='historyIncome'>
            <thead>
                <td>Date</td>
                <td>Amount</td>
                <td>From</td>
            </thead>
            
            <tbody>
                <template id='transferTemplate'>
                    <tr>
                        <td>{{date}}</td>
                        <td><span class='number'>{{amount}}</span></td>
                        <td>{{subject}}</td>
                    </tr>
                </template>
            </tbody>
        </table>
        
        <table id='historyOutcome'>
            <thead>
                <td>Date</td>
                <td>Amount</td>
                <td>To</td>
            </thead>
            
            <tbody>
                
            </tbody>
        </table>
    </div>
    
    
</div>
