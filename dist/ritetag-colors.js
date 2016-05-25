// Ritetag Colors 
// Author : Ahmed Saleh @mrxloka

(function() {
  var auto, ritetagcolors;

  ritetagcolors = (function() {    

    ritetagcolors.prototype.client = '';

    ritetagcolors.prototype.hashtags = [];

    ritetagcolors.prototype.ritething = function () {
       var req,
       colors = ["Unused", "Overused", "Good", "Great"],       
       
      req = new XMLHttpRequest();
      req.onreadystatechange = function() {
        var res;
        if (req.readyState === 4) {
          if (req.status === 200 || req.status === 304) {
            res = eval("(" + req.responseText + ")");
            console.log(res);        
            var data = document.getElementsByClassName('ritecolor')[0].innerHTML;         
            for (var i = res.length - 1; i >= 0; i--) {
              var hashtag = res[i]['tag'];
              var color = res[i]['color'];
              data = data.replace(new RegExp("#"+hashtag,'gi'), "<a target='_blank' class='"+colors[color]+"' href='https://ritetag.com/hashtag-stats/"+hashtag+"'>#"+hashtag+"</a>");
            }
            document.getElementsByClassName('ritecolor')[0].innerHTML = data;
          } else {
            console.log('Error loading data...');
          }
        }
      };
      var quer = "";
      this.hashtags.forEach(function (element, index, array){
           quer += "hashtags[]="+element+"&";
      });
      quer = quer.substring(0, quer.length - 1);	
      req.open('GET', "https://ritetag.com/api/v2.3/data/hashtag-stats/?"+quer+"&client_id="+this.client,true);
      req.send();
    };
    ritetagcolors.prototype.parseInput = function() {
      var i, len, match, ref, newdata;
      newdata = document.getElementsByClassName('ritecolor')[0].innerHTML;
      ref = newdata.match(/(^|\s)(#[a-z\d-]+)/ig);
      for (i = 0, len = ref.length; i < len; i++) {
        match = ref[i].trim().replace('#', '');      
          if (this.hashtags.indexOf(match) === -1){
            this.hashtags.push(match);
          }          
      }           
    };

    ritetagcolors.prototype.init = function(){
      this.parseInput();
      this.ritething();
    };

    function ritetagcolors() {
      
    };

    return ritetagcolors;

  })();

  auto = new ritetagcolors;
  window.ritetagcolors = auto;
}).call(this);


