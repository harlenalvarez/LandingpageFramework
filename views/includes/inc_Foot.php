</div>
<div class='footer'>
    <div class="pageFooter">
        <div class="side">
            <h4>Site Map</h4>
            <ul style="list-style:none;">
                <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                <li ng-repeat="section in sections" ng-if="section.type != 'division'"><a href="#{{section.ID}}"><i class="fa {{section.icon}}"></i> {{section.display}}</a></li>
                <li><a href="#contact"><i class="fa fa-comment"></i> Contact</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <span class="text-muted">&COPY; Creative, Inc. All rights reserved</span>
    </div>
    
</div>
 

<!--Scripts after page loads -->

</body>
</html>
