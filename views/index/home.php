
<div id="homeCtrl">
    <?php
        require_once(ROOT_INCLUDES."modules/programStatusModules.php");
        echo ProgramModules::slideShow($params['mainslide']);
    ?>

    <!--Sections-->
    <div ng-repeat="section in sections" class="sections-div">
        <!--Information Divs-->
        <div ng-if="section.type=='information_panels'" id="{{section.ID}}" class="flex-columns flex-space">
            <br/>
            <div ng-repeat="panel in section.element" class="information-panel">
                <div class="panel-image">
                    <img src="<?php echo URL_IMAGES_PATH?>{{panel.img}}" alt="{{panel.alt}}"/>
                </div>
                <div class="panel-information" ng-bind-html="panel.information | rawHtml">
                </div>
            </div>
        </div>
        <!--Division-->
        <div ng-if="section.type=='division'" id="{{section.ID}}" ng-bind-html="section.html | rawHtml"></div>
        <!--Extra Information-->
        <div ng-if="section.type=='floating_information'">
            <div id="{{section.ID}}" class="extra-information-wrapper">
                <br/>
                <div ng-repeat="extrainfo in section.element" style="clear:both" class="extra-info-div">
                    <h3>{{extrainfo.header}}</h3>
                    <img src="<?php echo URL_IMAGES_PATH?>{{extrainfo.img}}" alt="{{extrainfo.alt}}"/>
                    <p>{{extrainfo.content}}</p>
                </div>

            </div>
            <div style="clear:both"></div>
        </div>

    </div>
    <!--Contact Form-->
    <div class="contact-form-wrapper" id="contact">

        <?php if(isset($params['showMap']) && $params['showMap']){
            echo "<div class='googleMapCanvasWrapper'>";
            echo ProgramModules::googleMaps("mapDiv",$params['address']);
            echo "</div>";
        }
        ?>

        <div class="flex-columns">
            <div class="contact-information">
                <h3 class="full-width">Contact Information</h3>
                <table class="form-table">
                        <tr ng-repeat="contactInfo in contactInformation">
                            <td style="vertical-align: top;"><label>{{contactInfo.label}}</label>
                            </td><td ng-bind-html="contactInfo.info | rawHtml"></td>
                        </tr>
                </table>
            </div>
            <div class="contact-form">
                <h3 class="full-width">Send Us a message</h3>
                <form id="cif" name="cif" method="post" action="home" novalidate>
                    <div ng-repeat="fields in contactForm">
                        <p>
                            <div ng-if="fields.type == 'text'">
                                <label>{{fields.label}}</label><br/>
                                    <input type="text" class="form-control md-form" ng-validate="{{fields.validate}}" ng-required="fields.required" title="fields.title" name="{{fields.model}}" ng-model="$parent[fields.model]" />


                            </div>
                            <div ng-if="fields.type=='textarea'">
                                <label>{{fields.label}}</label><br/>
                                <textarea ng-required="fiels.required" ng-validate="{{fields.validate}}" class="form-control md-form" rows="6" title="fields.title" name="{{fields.model}}" ng-model="$paren[fields.model]">
                                </textarea>
                            </div>
                        </p>
                    </div>
                    <input type="submit" ng-disabled="cif.$invalid" name="contactFormSubmitButton" class="btn btn-site-bordered" value="Send Message">
                </form>
            </div>
        </div>
    </div>
</div>