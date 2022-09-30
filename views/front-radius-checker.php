<style>
      #map {
       height: 360px;
       width: 300px;
       overflow: hidden;
       float: left;
       border: thin solid #333;
       }
      #capture {
       height: 360px;
       width: 480px;
       overflow: hidden;
       float: left;
       background-color: #ECECFB;
       border: thin solid #333;
       border-left: none;
       }
    </style>
<div class="derc-front">
    <div class="derc-row">
        <label for="derc-address"><?php esc_html_e('Insert your address:', 'derc'); ?></label>
        <input type="text" name="address" id="derc-address" value="bandung">
    </div>
    <div class="derc-row">
        <input type="button" value="Check Address" id="derc-check-address">
    </div>
</div>

<div id="map"></div>
<div id="capture"></div>