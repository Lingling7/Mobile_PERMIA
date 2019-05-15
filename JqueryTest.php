var request = $.ajax({
  type: 'POST',
  url: 'Log.php',
  data: { type: "interface",
          link: "http://test.com",
          language: "zh-CN",
          title: "TEST title",
          snippet: "TEST snippet",
          rank: 1,
          currentinterface: "panel"},
  dataType: "html"
});
request.done(function( msg ) {
});
