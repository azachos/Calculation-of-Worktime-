//code based on http://jszen.blogspot.com/2007/03/how-to-build-simple-calendar-with.html#


// these are labels for the days of the week
cal_days_labels = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

// these are human-readable month name labels, in order
cal_months_labels = ['January', 'February', 'March', 'April',
									'May', 'June', 'July', 'August', 'September',
									'October', 'November', 'December'];

// these are the days of the week for each month, in order
cal_days_in_month = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

// this is the current date
cal_current_date = new Date(); 

function Calendar(month, year) {
				this.month = (isNaN(month) || month == null) ? cal_current_date.getMonth() : month;
				this.year  = (isNaN(year) || year == null) ? cal_current_date.getFullYear() : year;
				this.html = '';
}

function isHoliday(day, month, year) {
		if ((month == 3) && (day==25)) {
				return 'yes';
		 } else {
			return 'no';
		}
}

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

				// do the header
				var monthName = cal_months_labels[this.month]
								var html = '</br><table class="calendar-table">';
				html += '<tr><th colspan="7">';
				html +=  monthName + "&nbsp;" + this.year;

				html += '<tr>';
				html += '<td></td>';

				// fill in the days
				var day = 1;
				var day_num = startingDay;

				// this loop is for weekdays (cells)
				for (var j = startingDay; j < monthLength+startingDay; j++) { 
								if ((day_num == 6) || (day_num == 7))
												html += '<td class="calendar-weekend">';
								else
												html += '<td class="calendar-day">';

								if (day <= monthLength && (j >= startingDay)) {
												if (day_num == 7)
																day_num = 0;

												html += cal_days_labels[day_num] + ' '+ day;
												html += '<input type="hidden" id="holiday' + (day-1) + '" name="holiday" value="' + isHoliday(day,this.month,this.year) + '"</input>';
												day++;
												day_num++;

								}
								html += '</td>';
				}
				html += '</tr><tr>';

				html += '<td class="calendar-day"><p>Off</p>';
				html += '<p>End</p><p>Start</p></td>';
				var current,currentDay;
				for (var i = 0; i < monthLength; i++) { 
								html += '<td class="calendar-time">';
								current = new Date(this.year, this.month, i);
								currentDay = current.getDay();
								var e = document.getElementById("category");
								var category = e.options[e.selectedIndex].value;
								if ((currentDay <5) && (category != 'O')) {
									html += '<input type="checkbox" id="dayoff' + i +'"  value="no"/>';
								} else {
									html += '</br><input type="hidden" id="dayoff' + i +'"  value="no"/>';
								}
								html += '<input type="text" id="start_time_day' + i +'" name="start_time_day" size="1" class="input" value="12:00" />';
>>>>>>> origin/master
							//	html += '</td>';
				
				//html += '</br>';
				//html += '</tr><tr>';
				//html += '</br><td class="calendar-day">End</td>';
				//for (var i = 0; i < monthLength; i++) { 
							//	html += '<td class="calendar-time">';

								html += '<input type="text" id="end_time_day' + i +'"name=end_time_day' + i + ' size="4" class="input" value="21:00" />';
								html += '</br><input type="checkbox" id="dayoff' + i +' value="No" " />';
								html += '<input type="text" id="end_time_day' + i +'"name=end_time_day' + i + ' size="1" class="input" value="21:00" />';
								
								html += '</td>';
				}

				html += '</tr></table>';
				html += '<p><button type="button" onclick="loadXMLDoc()">Request data</button>'; 
				html += '<button type="button" onclick="loadGrid()">Clear data</button></p>'; 
			//	html += '</br><button type="button" onclick="loadXMLDoc()">Request data</button>'; 

				this.html = html;
}

Calendar.prototype.getHTML = function() {
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function()
				{
								if (xmlhttp.readyState==4 && xmlhttp.status==200)
								{
												//document.getElementById("otherDiv").innerHTML=xmlhttp.responseText;
												effect(xmlhttp.responseText);
								} else if (xmlhttp.readyState==3) {
									//document.getElementById("otherDiv").innerHTML="Loading...";
									//effect();
								}
				}
				xmlhttp.open("POST","test.php",true);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

				var e = document.getElementById("month");
				month++;
				var params = 'category=' + category + '&year=' + year +'&month=' + month + '&length=' + monthLength;
				for(var i = 0; i < monthLength; i++) {
					var a = document.getElementById("start_time_day"+i).value;
					var b = document.getElementById("end_time_day"+i).value;
					var c = document.getElementById("dayoff"+i).value;
					if (document.getElementById("dayoff"+i).checked)
						c = 'yes';
						
					var d = document.getElementById("holiday"+i).value;
					params += '&start_time_day'+i+'='+a+'&end_time_day'+i+'='+b+'&dayoff'+i+'='+c+'&holiday'+i+'='+d;
				}
				xmlhttp.send(params);
}

function effect(str){
    $("#otherDiv").fadeTo(300,0.0,function() {
        $("#otherDiv")
        .parent().prepend('<img src="loading.gif" />') //add the image to the container, so you can see it still
        .end().load(str, function(){
            $("#otherDiv")
            .parent().find('img').remove() //remove the image once the page is loaded. 
            .end().end().fadeTo(300,1.0);
			$("#otherDiv").html(str);
		});
    }); 
}
