////////////////                                                                                                                     

/*                                                                                                                                   
var currentdate = new Date();                                                                                                        
var datetime = "Last Sync: " + currentdate.getDate() + "/"                                                                           
    + (currentdate.getMonth()+1)  + "/"                                                                                              
    + currentdate.getFullYear() + " @ "                                                                                              
    + currentdate.getHours() + ":"                                                                                                   
    + currentdate.getMinutes() + ":"                                                                                                 
    + currentdate.getSeconds();                                                                                                      
                                                                                                                                     
                                                                                                                                     
// For todays date;                                                                                                                  
Date.prototype.today = function () {                                                                                                 
    return (((this.getMonth()+1) < 10)?"0":"") + (this.getMonth()+1) +"/"+((this.getDate() < 10)?"0":"") + (this.getDate() +"/"+ thi\
s.getFullYear());}                                                                                                                   
                                                                                                                                     
// For the time now                                                                                                                  
    Date.prototype.timeNow = function () {                                                                                           
        return ((this.getHours() < 10)?"0":"") + this.getHours() +":"+ ((this.getMinutes() < 10)?"0":"") + this.getMinutes() +":"+ (\
(this.getSeconds() < 10)?"0":"") + this.getSeconds();                                                                                
    };                                                                                                                               
                                                                                                                                     
var newDate = new Date();                                                                                                            
var datetime = "LastSync: " + newDate.today() + " @ " + newDate.timeNow();                                                           
                                                                                                                                     
console.log(datetime);                                                                                                               
                                                                                                                                     
/////////////////                                                                                                                    
                                                                                                                                     
// these are labels for the days of the week                                                                                         
cal_days_labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];                                                                 
                                                                                                                                     
// these are human-readable month name labels, in order                                                                              
cal_months_labels = ['January', 'February', 'March', 'April',                                                                        
                     'May', 'June', 'July', 'August', 'September',                                                                   
                     'October', 'November', 'December'];                                                                             
                                                                                                                                     
// these are the days in the for each month, in order                                                                                
cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];                                                                
                                                                                                                                     
                                                                                                                                     
//fallback object for current date                                                                                                   
cal_current_date = new Date();                                                                                                       
                                                               //constructor for the calendar                                                                                                       
                                                                                                                                     
function Calendar(month, year) {                                                                                                     
    this.month = (isNaN(month) || month == null) ? cal_current_date.getMonth() : month;                                              
    this.year  = (isNaN(year) || year == null) ? cal_current_date.getFullYear() : year;                                              
    this.html = '';                                                                                                                  
};                                                                                                                                   
                                                                                                                                     
                                                                                                                                     
                                                                                                                                     
Calendar.prototype.generateHTML = function(){                                                                                        
    // get first day of month                                                                                                        
    var firstDay = new Date(this.year, this.month, 1);                                                                               
    var startingDay = firstDay.getDay();                                                                                             
                                                                                                                                     
    // find number of days in month                                                                                                  
    var monthLength = cal_days_in_month[this.month];                                                                                 
                                                                                                                                     
    // compensate for leap year                                                                                                      
    if (this.month == 1) { // February only!                                                                                         
        if((this.year % 4 == 0 && this.year % 100 != 0) || this.year % 400 == 0){                                                    
            monthLength = 29;                                                                                                        
        }                                                                                                                            
    }                                                                                                                                
                                                                                                                                     
    // do the header                                                             var monthName = cal_months_labels[this.month]                                                                                    
    var html = '<table class="calendar-table">';                                                                                     
    html += '<tr><th colspan="7">';                                                                                                  
    html +=  monthName + "&nbsp;" + this.year;                                                                                       
    html += '</th></tr>';                                                                                                            
    html += '<tr class="calendar-header">';                                                                                          
    for(var i = 0; i <= 6; i++ ){                                                                                                    
        html += '<td class="calendar-header-day">';                                                                                  
        html += cal_days_labels[i];                                                                                                  
        html += '</td>';                                                                                                             
    }                                                                                                                                
    html += '</tr><tr>';                                                                                                             
                                                                                                                                     
    // fill in the days                                                                                                              
    var day = 1;                                                                                                                     
    // this loop is for is weeks (rows)                                                                                              
    for (var i = 0; i < 9; i++) {                                                                                                    
        // this loop is for weekdays (cells)                                                                                         
        for (var j = 0; j <= 6; j++) {                                                                                               
            html += '<td class="calendar-day">';                                                                                     
            if (day <= monthLength && (i > 0 || j >= startingDay)) {                                                                 
                html += day;                                                                                                         
                day++;                                                                                                               
            }                                                                                                                        
            html += '</td>';                                                                                                         
        }                                                                                                                            
        // stop making rows if we've run out of days                                                                                 
        if (day > monthLength) {                                                                                                     
            break;                                                                                                                   
        } else {                                                                                                                     
            html += '</tr><tr>';                                                                                                     
        }                                                                       }                                                                                                                                
    html += '</tr></table>';                                                                                                         
                                                                                                                                     
    this.html = html;                                                                                                                
};                                                                                                                                   
                                                                                                                                     
                                                                                                                                     
Calendar.prototype.getHTML = function() {                                                                                            
    return this.html;                                                                                                                
};                                                                                                                                   
                                                                                                                                     
*/
