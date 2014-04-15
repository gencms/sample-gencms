<!DOCTYPE html>
<html>
<head>
  <title>News Platform CMS</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap -->
  <link href="<?php echo base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" media="screen">
  <link href="<?php echo base_url() ?>assets/css/font-awesome.css" rel="stylesheet" media="screen">
  <link href="http://fonts.googleapis.com/css?family=Abel|Open+Sans:400,600" rel="stylesheet" />
  <link href="<?php echo base_url() ?>assets/css/custom-style.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>assets/css/jquery-ui.css" rel="stylesheet">
  <link href="<?php echo base_url() ?>assets/css/jquery.fancybox.css" rel="stylesheet">

  <?php if ( isset($css) && !empty($css) ) echo $css; ?>

  <script> var base_url = '<?php echo base_url() ?>' </script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/jscripts/jquery-1.9.1.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/jscripts/jquery-ui.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/jscripts/bootstrap.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/jscripts/jquery.dataTables.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/jscripts/jquery.fancybox.pack.js"></script>

  <script>
    /* Default class modification */
    $.extend( $.fn.dataTableExt.oStdClasses, {
      "sSortAsc": "header headerSortDown",
      "sSortDesc": "header headerSortUp",
      "sSortable": "header"
    } );

    /* API method to get paging information */
    $.fn.dataTableExt.oApi.fnPagingInfo = function ( oSettings )
    {
      return {
        "iStart":         oSettings._iDisplayStart,
        "iEnd":           oSettings.fnDisplayEnd(),
        "iLength":        oSettings._iDisplayLength,
        "iTotal":         oSettings.fnRecordsTotal(),
        "iFilteredTotal": oSettings.fnRecordsDisplay(),
        "iPage":          Math.ceil( oSettings._iDisplayStart / oSettings._iDisplayLength ),
        "iTotalPages":    Math.ceil( oSettings.fnRecordsDisplay() / oSettings._iDisplayLength )
      };
    }

    /* Bootstrap style pagination control */
    $.extend( $.fn.dataTableExt.oPagination, {
      "bootstrap": {
        "fnInit": function( oSettings, nPaging, fnDraw ) {
          var oLang = oSettings.oLanguage.oPaginate;
          var fnClickHandler = function ( e ) {
            e.preventDefault();
            if ( oSettings.oApi._fnPageChange(oSettings, e.data.action) ) {
              fnDraw( oSettings );
            }
          };

          $(nPaging).addClass('pagination').append(
            '<ul>'+
              '<li class="first disabled"><a href="#">&larr; '+oLang.sFirst+'</a></li>'+
              '<li class="prev disabled"><a href="#">&larr; '+oLang.sPrevious+'</a></li>'+
              '<li class="next disabled"><a href="#">'+oLang.sNext+' &rarr; </a></li>'+
              '<li class="last disabled"><a href="#">'+oLang.sLast+' &rarr; </a></li>'+
            '</ul>'
          );
          var els = $('a', nPaging);
              $(els[0]).bind( 'click.DT', { action: "first" }, fnClickHandler );
              $(els[1]).bind( 'click.DT', { action: "previous" }, fnClickHandler );
              $(els[2]).bind( 'click.DT', { action: "next" }, fnClickHandler );
              $(els[3]).bind( 'click.DT', { action: "last" }, fnClickHandler );
        },

        "fnUpdate": function ( oSettings, fnDraw ) {
          var iListLength = 5;
          var oPaging = oSettings.oInstance.fnPagingInfo();
          var an = oSettings.aanFeatures.p;
          var i, j, sClass, iStart, iEnd, iHalf=Math.floor(iListLength/2);

          if ( oPaging.iTotalPages < iListLength) {
            iStart = 1;
            iEnd = oPaging.iTotalPages;
          }
          else if ( oPaging.iPage <= iHalf ) {
            iStart = 1;
            iEnd = iListLength;
          } else if ( oPaging.iPage >= (oPaging.iTotalPages-iHalf) ) {
            iStart = oPaging.iTotalPages - iListLength + 1;
            iEnd = oPaging.iTotalPages;
          } else {
            iStart = oPaging.iPage - iHalf + 1;
            iEnd = iStart + iListLength - 1;
          }

          for ( i=0, iLen=an.length ; i<iLen ; i++ ) {
            // Remove the middle elements
            $('li:gt(0)', an[i]).filter(':not(:last)').remove();

            // Add the new list items and their event handlers
            for ( j=iStart ; j<=iEnd ; j++ ) {
              sClass = (j==oPaging.iPage+1) ? 'class="active"' : '';
              $('<li '+sClass+'><a href="#">'+j+'</a></li>')
                .insertBefore( $('li:last', an[i])[0] )
                .bind('click', function (e) {
                  e.preventDefault();
                  oSettings._iDisplayStart = (parseInt($('a', this).text(),10)-1) * oPaging.iLength;
                  fnDraw( oSettings );
                } );
            }

            // Add / remove disabled classes from the static elements
            if ( oPaging.iPage === 0 ) {
              $('li:first', an[i]).addClass('disabled');
            } else {
              $('li:first', an[i]).removeClass('disabled');
            }

            if ( oPaging.iPage === oPaging.iTotalPages-1 || oPaging.iTotalPages === 0 ) {
              $('li:last', an[i]).addClass('disabled');
            } else {
              $('li:last', an[i]).removeClass('disabled');
            }
          }
        }
      }
    } );
  </script>

  <?php if ( isset($js) && !empty($js) ) echo $js; ?>

  <script type="text/javascript" src="<?php echo base_url() ?>assets/jscripts/tinymce.min.js"></script>  
  <script>
    tinymce.init({
      mode            : "specific_textareas",
      editor_selector : "editor_field"
    });
  </script>

	<script>
    	$(function() {
          $(".delete").click( function(e) {
              if ($(this).attr('title')) {
                  var question = 'Are you sure you want to delete ' + $(this).attr('title').toUpperCase() + '?';
              } else {
                  var question = 'Are you sure you want to do this action?';
              }
              if ( confirm( question ) ) {
                  [removed].href = this.src;
              } else {
                  e.preventDefault()
              }
          });  

          $( ".datepicker" ).datepicker({
             changeMonth: true,
             changeYear: true,
             dateFormat: 'yy-mm-dd',
    	       yearRange:'c-80:c+0'
          });   

          $('.zoomify').fancybox();       
      });
  </script>
</head>  
<body>
   <div class="container">    
    <?php $this->load->view("common/logo.php"); ?>

    <div class="row" id="cms_menu">
	     <?php $this->load->view("common/navigation.php"); ?>
    </div>

    <div class="row">

<!-- Header file ends here. -->
