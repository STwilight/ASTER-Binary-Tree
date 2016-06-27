window.onload = function() {
	var drawingCanvas = document.getElementById("space");
	var drawningWidth = 4000;//document.body.clientWidth-5;
	var drawningHeight = window.innerHeight-20;
	drawingCanvas.width = drawningWidth;
	drawingCanvas.height = drawningHeight;
	function drawGrid(size, color) {
		// vertical lines drawning
		for (var x = 9.5; x < drawningWidth; x += size) {
			context.moveTo(x, 0);
			context.lineTo(x, drawningHeight);
		}
		// horizontal lines drawning
		for (var y = 0.5; y < drawningHeight; y += size) {
			context.moveTo(0, y);
			context.lineTo(drawningWidth, y);
		}
		// color filling
		context.strokeStyle = color;
		context.stroke();				
	}
	function drawCell(x, y, width, height, border, borderColor, fillingColor, number, name, textColor) {
		// border drawning
		context.strokeStyle = borderColor;
		context.strokeRect(x, y, width, height);
		// cell drawning
		context.fillStyle = fillingColor;
		context.fillRect(x + border, y + border, width - border*2, height - border*2);
		// text output
		if (number != null && name != null)
		{
			context.fillStyle = textColor;
			content.textAlign = "center";
			context.textBaseline = "middle";
			context.font = "bold 14px sans-serif";
			context.fillText(number, x + border*2.5, y + (height/3) + (border/2));
			context.font = "12px sans-serif";
			context.fillText(name, x + border*3, y + height - (height/3) + (border/2));
		}
	}
	function drawRow(x, y, width, height, border, blank, count) {
		for(var i = x; i < x+(blank+width)*count; i+=blank+width)
			drawCell(i, y, width, height, border, "#00FF00", "#FF0000", "XX000000000", "Contract holder", "#000000");		
	}
	function drawTree(rowsCount) {
		for(var i = 0, j = rowsCount-1; i < rowsCount, j >= 0; i++, j--) {
			var pwr = Math.pow(2, i);
			var invertPwr = Math.pow(2, j);
			var coefficient = 0;
			if(i != 0 && i != rowsCount-1)
				coefficient = 1;
			else
				coefficient = 0;
			drawRow((((drawningWidth-(100*pwr+25*(pwr-1)))/2)-(100+25+(100+25)/2)*coefficient), 50+100*i, 100, 50, 2, 100*(invertPwr-1)+25*invertPwr, pwr);
		}
	}
	if(drawingCanvas && drawingCanvas.getContext) {
		var context = drawingCanvas.getContext("2d");
		drawGrid(25, "#C0C0C0");
		
		//drawTree(4);
		// drawRow((((drawningWidth-(100*1+25*0))/2/*659.5*/)-(100+25+(100+25)/2)*0/*000.0*/), 50+100*0, 100, 50, 2, 100*7+25*8, 1);
		// drawRow((((drawningWidth-(100*2+25*1))/2/*597.0*/)-(100+25+(100+25)/2)*1/*187.5*/), 50+100*1, 100, 50, 2, 100*3+25*4, 2);
		// drawRow((((drawningWidth-(100*4+25*3))/2/*472.0*/)-(100+25+(100+25)/2)*1/*187.5*/), 50+100*2, 100, 50, 2, 100*1+25*2, 4);
		// drawRow((((drawningWidth-(100*8+25*7))/2/*222.0*/)-(100+25+(100+25)/2)*0/*000.0*/), 50+100*3, 100, 50, 2, 100*0+25*1, 8);
		
		drawRow((((drawningWidth-(100*1 +25*0 ))/2)-(100+25+(100+25)/2)*0), 50+100*0, 100, 50, 2, 100*31+25*32, 1 );
		drawRow((((drawningWidth-(100*2 +25*1 ))/2)-(100+25+(100+25)/2)*5), 50+100*1, 100, 50, 2, 100*15+25*16, 2 );
		drawRow((((drawningWidth-(100*4 +25*3 ))/2)-(100+25+(100+25)/2)*7), 50+100*2, 100, 50, 2, 100*7 +25*8 , 4 );
		drawRow((((drawningWidth-(100*8 +25*7 ))/2)-(100+25+(100+25)/2)*7), 50+100*3, 100, 50, 2, 100*3 +25*4 , 8 );		
		drawRow((((drawningWidth-(100*16+25*15))/2)-(100+25+(100+25)/2)*5), 50+100*4, 100, 50, 2, 100*1 +25*2 , 16);
		drawRow((((drawningWidth-(100*32+25*31))/2)-(100+25+(100+25)/2)*0), 50+100*5, 100, 50, 2, 100*0 +25*1 , 32);		
	}
}