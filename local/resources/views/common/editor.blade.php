	<script src="http://cdn.ckeditor.com/4.5.8/standard-all/ckeditor.js"></script>
<script>
  $(function() {
  $('.ckeditor').each(function(){  
CKEDITOR.replace($(this).attr('id'), {
extraPlugins: 'mathjax',
mathJaxLib: 'http://cdn.mathjax.org/mathjax/2.6-latest/MathJax.js?config=TeX-AMS_HTML',
height: 320
});
});  
  });  
</script>
<script type="text/x-mathjax-config">
     MathJax.Hub.Config({tex2jax: {inlineMath: [['\\(','\\)']]}});
   </script>
   <script type="text/javascript"
     src="http://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML">
   </script>
<script type="text/x-mathjax-config">
MathJax.Hub.Register.StartupHook("End Jax",function () {
 var BROWSER = MathJax.Hub.Browser;
 var jax = "SVG";
 //var jax = "HTML-CSS";
 if (BROWSER.isMSIE && BROWSER.hasMathPlayer) jax = "NativeMML";
 if (BROWSER.isFirefox) jax = "SVG";
 if (BROWSER.isSafari && BROWSER.versionAtLeast("5.0")) jax = "NativeMML";
 return MathJax.Hub.setRenderer(jax);
});
</script>