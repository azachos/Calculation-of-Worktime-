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
								var html = '<button type="button" onclick="loadXMLDoc()">Request data</button>'; 
								html += '</br><table class="calendar-table">';
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
												day++;
												day_num++;

								}
								html += '</td>';
				}
				html += '</tr><tr>';

				html += '<td class="calendar-day"><p>Start</p>';
				html += '<p>End</p><p>Day Off</p></td>';
				for (var i = 0; i < monthLength; i++) { 
								html += '<td class="calendar-time">';
								html += '<input type="text" id="start_time_day' + i +'" name="start_time_day"  size="4" class="input" value="12:00" />';
							//	html += '</td>';
				
				html += '</br>';
				//html += '</tr><tr>';
				//html += '</br><td class="calendar-day">End</td>';
				//for (var i = 0; i < monthLength; i++) { 
							//	html += '<td class="calendar-time">';
								html += '<input type="text" id="end_time_day' + i +'"name=end_time_day' + i + ' size="4" class="input" value="21:00" />';
								html += '</br><input type="checkbox" id="dayoff' + i +' value="No" " />';
								html += '</td>';
				}

				html += '</tr></table>';
			//	html += '</br><button type="button" onclick="loadXMLDoc()">Request data</button>'; 

				this.html = html;
}

Calendar.prototype.getHTML = function() {
				return this.html;
}

Calendar.prototype.getMonthLength
function loadGrid() {
				var e = document.getElementById("month");
				var str = e.options[e.selectedIndex].value;
				var cal = new Calendar(str);
				cal.generateHTML();
				document.getElementById("myDiv").innerHTML = cal.getHTML();

}

function Show() {
				var e = document.getElementById("month");
				var str = e.options[e.selectedIndex].value;
				var monthLength = cal_days_in_month[str];
				str++;

				var html = 'start' + monthLength + '</br>';
				//	document.getElementById("otherDiv").innerHTML = html;


				for (var i = 0; i < monthLength; i++) {
								var time = document.getElementById("start_time_day"+i).value;
								html += '2011/' + str + '/' + (i+1) + '  ' + time  +  ':00:000</br>';
				}
				html += 'end';
				this.html = html;
				document.getElementById("otherDiv").innerHTML = this.html;

}

function loadXMLDoc()
{
				var xmlhttp;
				if (window.XMLHttpRequest)
				{// code for IE7+, Firefox, Chrome, Opera, Safari
								xmlhttp=new XMLHttpRequest();
				}
				else
				{// code for IE6, IE5
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange=function()
				{
								if (xmlhttp.readyState==4 && xmlhttp.status==200)
								{
												document.getElementById("otherDiv").innerHTML=xmlhttp.responseText;
								} else if (xmlhttp.readyState==3) {
									document.getElementById("otherDiv").innterHTML="Loading...";
								}
				}
				xmlhttp.open("POST","test.php",true);
				xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

				var e = document.getElementById("month");
				var month = e.options[e.selectedIndex].value;
				var monthLength = cal_days_in_month[month];
				var e = document.getElementById("category");
				var category = e.options[e.selectedIndex].value;
				var year = cal_current_date.getFullYear();
				month++;
				var params = 'category=' + category + '&year=' + year +'&month=' + month + '&length=' + monthLength;
				for(var i = 0; i < monthLength; i++) {
					var a = document.getElementById("start_time_day"+i).value;
					var b = document.getElementById("end_time_day"+i).value;
					var c = document.getElementById("dayoff"+i).value;
					params += '&start_time_day'+i+'='+a+'&end_time_day'+i+'='+b+'&dayoff'+i+'='+c;
				}
				xmlhttp.send(params);
}
