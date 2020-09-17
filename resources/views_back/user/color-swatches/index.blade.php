@extends('layouts.user.app')

@section('content')
<div id="color-swatches">
	<div class="container">
        <div class="heading">Color Chats and brochures</div>
        <div class="sub-heading">Browse by colour scheme</div>
		<div class ="color-tab">
			<div class="tab">
			  <div class="tablinks" onclick="produ(event, 'White')">
	          <div class="color-picker">
	            <div class="color-box" style="background-color:#F6F7F2;"></div>
	            <div class="ttl">Whites </br>& Neutrals</div>
	          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Grey')">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#373E42;"></div>
		            <div class="ttl">Greys</div>
		          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Brown')" id="defaultOpen">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#B39F94;"></div>
		            <div class="ttl">Browns</div>
		          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Purple')">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#7E7999;"></div>
		            <div class="ttl">Purples</div>
		          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Blue')">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#29436E;"></div>
		            <div class="ttl">Blue</div>
		          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Green')">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#9DBFAF;"></div>
		            <div class="ttl">Greens</div>
		          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Yellow')">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#FAE196;"></div>
		            <div class="ttl">Yellows</div>
		          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Orange')">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#CC5327;"></div>
		            <div class="ttl">Oranges</div>
		          </div>
			  </div>
			  <div class="tablinks" onclick="produ(event, 'Red')">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#A8312F;"></div>
		            <div class="ttl">Reds</div>
		          </div>
			  </div>
			</div>
		</div>
		<div class="color-section">
			<div id="White" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>		          
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>   		            
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>               
		          </div>
				</div>
			</div>
			<div id="Grey" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		            <div class="color-box" style="background-color:#D3D3D3;">
		            	<div class="title">LightGray</div>
		            </div>
		            <div class="color-box" style="background-color:#DCDCDC">
		            	<div class="title">Gainsboro</div>
		            </div>
		            <div class="color-box" style="background-color:#b7b7b7;">
		            	<div class="title">Whitesmoke</div>
		            </div>
		            <div class="color-box" style="background-color:#C0C0C0;">
		            	<div class="title">Silver</div>
		            </div>        
		            <div class="color-box" style="background-color:#BEBEBE;">
		            	<div class="title">X11 Gray</div>
		            </div>
		          </div>
				</div>
			</div>
			<div id="Brown" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#FFE4C4;">
		            	<div class="title">bisque</div>
		            </div>
		            <div class="color-box" style="background-color:#FFDEAD;">
		            	<div class="title">Navajowhite</div>  
		            </div>        
		            <div class="color-box" style="background-color:#F5DEB3;">
		            	<div class="title">Wheat</div>
		            </div>      
		            <div class="color-box" style="background-color:#DEB887;">
		            	<div class="title">Burlywood</div>
		            </div>
		            <div class="color-box" style="background-color:#F4A460;">
		            	<div class="title">sandybrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#FFE4C4;">
		            	<div class="title">bisque</div>
		            </div>
		            <div class="color-box" style="background-color:#FFDEAD;">
		            	<div class="title">Navajowhite</div>  
		            </div>        
		            <div class="color-box" style="background-color:#F5DEB3;">
		            	<div class="title">Wheat</div>
		            </div>      
		            <div class="color-box" style="background-color:#DEB887;">
		            	<div class="title">Burlywood</div>
		            </div>
		            <div class="color-box" style="background-color:#F4A460;">
		            	<div class="title">sandybrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#FFE4C4;">
		            	<div class="title">bisque</div>
		            </div>
		            <div class="color-box" style="background-color:#FFDEAD;">
		            	<div class="title">Navajowhite</div>  
		            </div>        
		            <div class="color-box" style="background-color:#F5DEB3;">
		            	<div class="title">Wheat</div>
		            </div>      
		            <div class="color-box" style="background-color:#DEB887;">
		            	<div class="title">Burlywood</div>
		            </div>
		            <div class="color-box" style="background-color:#F4A460;">
		            	<div class="title">sandybrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>	            
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#FFE4C4;">
		            	<div class="title">bisque</div>
		            </div>
		            <div class="color-box" style="background-color:#FFDEAD;">
		            	<div class="title">Navajowhite</div>  
		            </div>        
		            <div class="color-box" style="background-color:#F5DEB3;">
		            	<div class="title">Wheat</div>
		            </div>      
		            <div class="color-box" style="background-color:#DEB887;">
		            	<div class="title">Burlywood</div>
		            </div>
		            <div class="color-box" style="background-color:#F4A460;">
		            	<div class="title">sandybrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#FFE4C4;">
		            	<div class="title">bisque</div>
		            </div>
		            <div class="color-box" style="background-color:#FFDEAD;">
		            	<div class="title">Navajowhite</div>  
		            </div>        
		            <div class="color-box" style="background-color:#F5DEB3;">
		            	<div class="title">Wheat</div>
		            </div>      
		            <div class="color-box" style="background-color:#DEB887;">
		            	<div class="title">Burlywood</div>
		            </div>
		            <div class="color-box" style="background-color:#F4A460;">
		            	<div class="title">sandybrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#8B4513;">
		            	<div class="title">Saddlebrown</div>
		            </div>
		            <div class="color-box" style="background-color:#FFE4C4;">
		            	<div class="title">bisque</div>
		            </div>
		            <div class="color-box" style="background-color:#FFDEAD;">
		            	<div class="title">Navajowhite</div>  
		            </div>        
		            <div class="color-box" style="background-color:#F5DEB3;">
		            	<div class="title">Wheat</div>
		            </div>      
		            <div class="color-box" style="background-color:#DEB887;">
		            	<div class="title">Burlywood</div>
		            </div>
		          </div>
				</div>
			</div>
			<div id="Purple" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#E6E6FA;">
		            	<div class="title">lavender</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Thistle</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Plum</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Violet</div>    
		            </div>        
		            <div class="color-box" style="background-color:#DA70D6;">
		            	<div class="title">Orchid</div>
		            </div>
		            <div class="color-box" style="background-color:#FF00FF;">
		            	<div class="title">Fuchsia</div>
		            </div>
		            <div class="color-box" style="background-color:#E6E6FA;">
		            	<div class="title">lavender</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Thistle</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Plum</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Violet</div>    
		            </div>        
		            <div class="color-box" style="background-color:#DA70D6;">
		            	<div class="title">Orchid</div>
		            </div>
		            <div class="color-box" style="background-color:#FF00FF;">
		            	<div class="title">Fuchsia</div>
		            </div>
		            <div class="color-box" style="background-color:#E6E6FA;">
		            	<div class="title">lavender</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Thistle</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Plum</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Violet</div>    
		            </div>        
		            <div class="color-box" style="background-color:#DA70D6;">
		            	<div class="title">Orchid</div>
		            </div>
		            <div class="color-box" style="background-color:#FF00FF;">
		            	<div class="title">Fuchsia</div>
		            </div>
		            <div class="color-box" style="background-color:#E6E6FA;">
		            	<div class="title">lavender</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Thistle</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Plum</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Violet</div>    
		            </div>        
		            <div class="color-box" style="background-color:#DA70D6;">
		            	<div class="title">Orchid</div>
		            </div>
		            <div class="color-box" style="background-color:#FF00FF;">
		            	<div class="title">Fuchsia</div>
		            </div>
		            <div class="color-box" style="background-color:#E6E6FA;">
		            	<div class="title">lavender</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Thistle</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Plum</div>
		            </div>
		            <div class="color-box" style="background-color:#D8BFD8;">
		            	<div class="title">Violet</div>    
		            </div>        
		            <div class="color-box" style="background-color:#DA70D6;">
		            	<div class="title">Orchid</div>
		            </div>
		            <div class="color-box" style="background-color:#FF00FF;">
		            	<div class="title">Fuchsia</div>
		            </div>
		          </div>
				</div>
			</div>
			<div id="Blue" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#ADD8E6;">
		            	<div class="title">lightblue</div>
		            </div>
		            <div class="color-box" style="background-color:#87CEFA;">
		            	<div class="title">Deepblue</div>
		            </div>
		            <div class="color-box" style="background-color:#1E90FF;">
		            	<div class="title">steelblue</div>    
		            </div>        
		            <div class="color-box" style="background-color:#4169E1;">
		            	<div class="title">Royalblue</div>
		            </div>
		            <div class="color-box" style="background-color:#B0E0E6;">
		            	<div class="title">powderblue</div>
		            </div>
		            <div class="color-box" style="background-color:#ADD8E6;">
		            	<div class="title">lightblue</div>
		            </div>
		            <div class="color-box" style="background-color:#87CEFA;">
		            	<div class="title">Deepblue</div>
		            </div>
		            <div class="color-box" style="background-color:#B0E0E6;">
		            	<div class="title">powderblue</div>
		            </div>
		            <div class="color-box" style="background-color:#ADD8E6;">
		            	<div class="title">lightblue</div>
		            </div>
		            <div class="color-box" style="background-color:#87CEFA;">
		            	<div class="title">Deepblue</div>
		            </div>
		            <div class="color-box" style="background-color:#1E90FF;">
		            	<div class="title">steelblue</div>    
		            </div>        
		            <div class="color-box" style="background-color:#4169E1;">
		            	<div class="title">Royalblue</div>
		            </div>
		            <div class="color-box" style="background-color:#B0E0E6;">
		            	<div class="title">powderblue</div>
		            </div>
		            <div class="color-box" style="background-color:#1E90FF;">
		            	<div class="title">steelblue</div>    
		            </div>        
		            <div class="color-box" style="background-color:#4169E1;">
		            	<div class="title">Royalblue</div>
		            </div>
		            <div class="color-box" style="background-color:#B0E0E6;">
		            	<div class="title">powderblue</div>
		            </div>
		            <div class="color-box" style="background-color:#ADD8E6;">
		            	<div class="title">lightblue</div>
		            </div>
		            <div class="color-box" style="background-color:#87CEFA;">
		            	<div class="title">Deepblue</div>
		            </div>
		            <div class="color-box" style="background-color:#1E90FF;">
		            	<div class="title">steelblue</div>    
		            </div>
		            <div class="color-box" style="background-color:#87CEFA;">
		            	<div class="title">Deepblue</div>
		            </div>
		            <div class="color-box" style="background-color:#1E90FF;">
		            	<div class="title">steelblue</div>    
		            </div>        
		            <div class="color-box" style="background-color:#4169E1;">
		            	<div class="title">Royalblue</div>
		            </div>
		            <div class="color-box" style="background-color:#B0E0E6;">
		            	<div class="title">powderblue</div>
		            </div>        
		            <div class="color-box" style="background-color:#4169E1;">
		            	<div class="title">Royalblue</div>
		            </div>
		            <div class="color-box" style="background-color:#B0E0E6;">
		            	<div class="title">powderblue</div>
		            </div>
		            <div class="color-box" style="background-color:#ADD8E6;">
		            	<div class="title">lightblue</div>
		            </div>
		            <div class="color-box" style="background-color:#ADD8E6;">
		            	<div class="title">lightblue</div>
		            </div>
		            <div class="color-box" style="background-color:#87CEFA;">
		            	<div class="title">Deepblue</div>
		            </div>
		            <div class="color-box" style="background-color:#1E90FF;">
		            	<div class="title">steelblue</div>    
		            </div>        
		            <div class="color-box" style="background-color:#4169E1;">
		            	<div class="title">Royalblue</div>
		            </div>  
		          </div>
				</div>
			</div>
			<div id="Green" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">green</div>
		            </div>
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">darkgreen</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">greenyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">lawngreen</div>    
		            </div>        
		            <div class="color-box" style="background-color:#9ACD32;">
		            	<div class="title">yellowgreen</div>
		            </div>
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">green</div>
		            </div>
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">darkgreen</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">greenyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">lawngreen</div>    
		            </div>        
		            <div class="color-box" style="background-color:#9ACD32;">
		            	<div class="title">yellowgreen</div>
		            </div>
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">green</div>
		            </div>
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">darkgreen</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">greenyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">lawngreen</div>    
		            </div>        
		            <div class="color-box" style="background-color:#9ACD32;">
		            	<div class="title">yellowgreen</div>
		            </div>
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">green</div>
		            </div>
		            <div class="color-box" style="background-color:#008000;">
		            	<div class="title">darkgreen</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">greenyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#ADFF2F;">
		            	<div class="title">lawngreen</div>    
		            </div>        
		            <div class="color-box" style="background-color:#9ACD32;">
		            	<div class="title">yellowgreen</div>
		            </div>     
		          </div>
				</div>
			</div>
			<div id="Yellow" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#FFFFE0;">
		            	<div class="title">lightyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#FFFACD;">
		            	<div class="title">lemonchiffon</div>
		            </div>
		            <div class="color-box" style="background-color:#FAFAD2;">
		            	<div class="title">goldyell</div>
		            </div>
		            <div class="color-box" style="background-color:#F0E68C;">
		            	<div class="title">darki</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FFFF00;">
		            	<div class="title">yellow</div>
		            </div>
		            <div class="color-box" style="background-color:#FFFFE0;">
		            	<div class="title">lightyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#FFFACD;">
		            	<div class="title">lemonchiffon</div>
		            </div>
		            <div class="color-box" style="background-color:#FAFAD2;">
		            	<div class="title">goldyell</div>
		            </div>
		            <div class="color-box" style="background-color:#F0E68C;">
		            	<div class="title">darki</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FFFF00;">
		            	<div class="title">yellow</div>
		            </div> 
		            <div class="color-box" style="background-color:#FFFFE0;">
		            	<div class="title">lightyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#FFFACD;">
		            	<div class="title">lemonchiffon</div>
		            </div>
		            <div class="color-box" style="background-color:#FAFAD2;">
		            	<div class="title">goldyell</div>
		            </div>
		            <div class="color-box" style="background-color:#F0E68C;">
		            	<div class="title">darki</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FFFF00;">
		            	<div class="title">yellow</div>
		            </div>  
		            <div class="color-box" style="background-color:#FFFFE0;">
		            	<div class="title">lightyellow</div>
		            </div>
		            <div class="color-box" style="background-color:#FFFACD;">
		            	<div class="title">lemonchiffon</div>
		            </div>
		            <div class="color-box" style="background-color:#FAFAD2;">
		            	<div class="title">goldyell</div>
		            </div>
		            <div class="color-box" style="background-color:#F0E68C;">
		            	<div class="title">darki</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FFFF00;">
		            	<div class="title">yellow</div>
		            </div>  
		          </div>
		        </div>
			</div>
			<div id="Orange" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#FF7F50;">
		            	<div class="title">coral</div>
		            </div>
		            <div class="color-box" style="background-color:#FF6347;">
		            	<div class="title">tomato</div>
		            </div>
		            <div class="color-box" style="background-color:#FF4500;">
		            	<div class="title">orange</div>
		            </div>
		            <div class="color-box" style="background-color:#FFA500;">
		            	<div class="title">ornge</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FF8C00;">
		            	<div class="title">darkorange</div>
		            </div> 
		            <div class="color-box" style="background-color:#FF7F50;">
		            	<div class="title">coral</div>
		            </div>
		            <div class="color-box" style="background-color:#FF6347;">
		            	<div class="title">tomato</div>
		            </div>
		            <div class="color-box" style="background-color:#FF4500;">
		            	<div class="title">orange</div>
		            </div>
		            <div class="color-box" style="background-color:#FFA500;">
		            	<div class="title">ornge</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FF8C00;">
		            	<div class="title">darkorange</div>
		            </div> 
		            <div class="color-box" style="background-color:#FF7F50;">
		            	<div class="title">coral</div>
		            </div>
		            <div class="color-box" style="background-color:#FF6347;">
		            	<div class="title">tomato</div>
		            </div>
		            <div class="color-box" style="background-color:#FF4500;">
		            	<div class="title">orange</div>
		            </div>
		            <div class="color-box" style="background-color:#FFA500;">
		            	<div class="title">ornge</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FF8C00;">
		            	<div class="title">darkorange</div>
		            </div> 
		            <div class="color-box" style="background-color:#FF7F50;">
		            	<div class="title">coral</div>
		            </div>
		            <div class="color-box" style="background-color:#FF6347;">
		            	<div class="title">tomato</div>
		            </div>
		            <div class="color-box" style="background-color:#FF4502;">
		            	<div class="title">orange</div>
		            </div>
		            <div class="color-box" style="background-color:#FFA500;">
		            	<div class="title">ornge</div>    
		            </div>        
		            <div class="color-box" style="background-color:#FF8C00;">
		            	<div class="title">darkorange</div>
		            </div> 
		          </div>
		        </div>
			</div>
			<div id="Red" class="tabcontent">
				<div class="box-widget">
		          <div class="color-picker">
		            <div class="color-box" style="background-color:#CD5C5C;">
		            	<div class="title">indianred</div>
		            </div>
		            <div class="color-box" style="background-color:#DC143C;">
		            	<div class="title">crimson</div>
		            </div>
		            <div class="color-box" style="background-color:#B22222;">
		            	<div class="title">firebrick</div>
		            </div>
		            <div class="color-box" style="background-color:#FF0000;">
		            	<div class="title">red</div>    
		            </div>        
		            <div class="color-box" style="background-color:#8B0000;">
		            	<div class="title">darkred</div>
		            </div>
		            <div class="color-box" style="background-color:#CD5C5C;">
		            	<div class="title">indianred</div>
		            </div>
		            <div class="color-box" style="background-color:#DC143C;">
		            	<div class="title">crimson</div>
		            </div>
		            <div class="color-box" style="background-color:#B22222;">
		            	<div class="title">firebrick</div>
		            </div>
		            <div class="color-box" style="background-color:#FF0000;">
		            	<div class="title">red</div>    
		            </div>        
		            <div class="color-box" style="background-color:#8B0000;">
		            	<div class="title">darkred</div>
		            </div>
		            <div class="color-box" style="background-color:#CD5C5C;">
		            	<div class="title">indianred</div>
		            </div>
		            <div class="color-box" style="background-color:#DC143C;">
		            	<div class="title">crimson</div>
		            </div>
		            <div class="color-box" style="background-color:#B22222;">
		            	<div class="title">firebrick</div>
		            </div>
		            <div class="color-box" style="background-color:#FF0000;">
		            	<div class="title">red</div>    
		            </div>        
		            <div class="color-box" style="background-color:#8B0000;">
		            	<div class="title">darkred</div>
		            </div>
		            <div class="color-box" style="background-color:#CD5C5C;">
		            	<div class="title">indianred</div>
		            </div>
		            <div class="color-box" style="background-color:#DC143C;">
		            	<div class="title">crimson</div>
		            </div>
		            <div class="color-box" style="background-color:#B22222;">
		            	<div class="title">firebrick</div>
		            </div>
		            <div class="color-box" style="background-color:#FF0000;">
		            	<div class="title">red</div>    
		            </div>        
		            <div class="color-box" style="background-color:#8B0000;">
		            	<div class="title">darkred</div>
		            </div>
		            <div class="color-box" style="background-color:#CD5C5C;">
		            	<div class="title">indianred</div>
		            </div>
		            <div class="color-box" style="background-color:#DC143C;">
		            	<div class="title">crimson</div>
		            </div>
		            <div class="color-box" style="background-color:#B22222;">
		            	<div class="title">firebrick</div>
		            </div>
		            <div class="color-box" style="background-color:#FF0000;">
		            	<div class="title">red</div>    
		            </div>        
		            <div class="color-box" style="background-color:#8B0000;">
		            	<div class="title">darkred</div>
		            </div>
		            <div class="color-box" style="background-color:#CD5C5C;">
		            	<div class="title">indianred</div>
		            </div>
		            <div class="color-box" style="background-color:#DC143C;">
		            	<div class="title">crimson</div>
		            </div>
		            <div class="color-box" style="background-color:#B22222;">
		            	<div class="title">firebrick</div>
		            </div>
		            <div class="color-box" style="background-color:#FF0000;">
		            	<div class="title">red</div>    
		            </div>        
		            <div class="color-box" style="background-color:#8B0000;">
		            	<div class="title">darkred</div>
		            </div>
		          </div>
		        </div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function produ(evt, prd) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(prd).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();

</script>

@endsection