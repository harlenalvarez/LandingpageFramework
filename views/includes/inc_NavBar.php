<!--Navigation-->
<nav class="navbar navbar-default navbar-fixed-top" id="main-nav">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="<?php echo URL_IMAGES_PATH.$params['logo']?>" alt="Company Logo"/></a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="/"><i class="fa fa-home"></i> Home</a></li>
                <li ng-repeat="section in sections" ng-if="section.type != 'division'"><a href="#{{section.ID}}"><i class="fa {{section.icon}}"></i> {{section.display}}</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#contact"><i class="fa fa-comment"></i> Contact</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>