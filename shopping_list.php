<?php  

require_once(dirname( __FILE__ ) . '/scripts.php');

?>

<div class="hidden-meta" data-gsn-title="{{ChainName}} my shopping list"></div>
<div data-ctrl-shopping-list="" data-gsn-shopping-list="">
  <div class="col-md-9">
    <div data-gsn-ad-unit="1" data-ng-if="',visible-lg,visible-md'.indexOf(bsDisplayMode) > 0"></div>
    <div class="row" style="padding-top: 5px">
      <div class="col-md-3 adUnit6">
        <div data-gsn-ad-unit="6" data-ng-if="',visible-lg,visible-md'.indexOf(bsDisplayMode) > 0" data-gsn-sticky=".adUnit6" data-bottom="200" data-top="60"></div>
      </div>
      <div class="col-md-9">
        <div data-gsn-spinner="{radius:30, width:8, length: 16}" data-show-if="!mylist.hasLoaded()"></div>
        <div class="sponsor" data-gsn-ad-unit="9" data-ng-if="',visible-lg,visible-md'.indexOf(bsDisplayMode) > 0"></div>
        <h1>My Shopping List</h1>
        <div class="row">
          <div class="col-md-4">
            <div class="input-group addItemManage">
              <input type="text" class="form-control" data-ng-model="addString" placeholder="add own item" ui-keypress="{13:'doAddOwnItem()'}">
              <span class="input-group-btn">
                <button class="btn btn-primary" data-ng-click="doAddOwnItem()" type="button">Add</button>
              </span>
            </div>
          </div>
          <div class="col-md-8">
            <div class="btn-group" data-ng-show="mylist.hasLoaded()">
              <button type="button" class="btn btn-primary" data-ng-click="goUrl('/mylist/print')"><i class="fa fa-print"></i><br />Print</button>
              <button type="button" class="btn btn-primary" data-ng-click="goUrl('/mylist/email')"><i class="fa fa-envelope"></i><br />Email</button>
              <button type="button" class="btn btn-primary" data-ng-click="goUrl('/savedlists')"><i class="fa fa-folder-open"></i><br />Previous</a></button>
              <button type="button" class="btn btn-primary" data-gsn-modal="getThemeUrl('/views/engine/modal-shopping-list-title.html')" data-ng-click="doIfLoggedIn(showModal)"><i class="fa fa-file"></i><br />Save</button>
              <button type="button" class="btn btn-primary" data-ng-click="deleteCurrentList()"><i class="fa fa-minus-circle"></i><br />Delete</button>
              <button type="button" class="btn btn-primary" data-ng-click="startNewList()"><i class="fa fa-plus-circle"></i><br />New</button>
            </div>
          </div>
        </div>
        <div>
          <div data-ng-repeat="groupItem in allItems" data-ng-if="groupItem.fitems.length > 0">
            <div class="row">
              <div class="col-md-8 col-xs-8">
                <h4>{{groupItem.key}}</h4>
              </div>
              <div class="col-md-4 col-xs-4">
                <h4>Quantity</h4>
              </div>
            </div>
            <div class="row thumbnail" data-ng-repeat="item in groupItem.fitems">
              <div class="col-md-8 col-xs-8">
                <div class="pull-left" style="padding-right: 5px;">
                  <img style="width: 60px" data-ng-src="{{item.SmallImageUrl || getThemeUrl('/images/no_image.jpg')}}" />
                </div>
                <span data-ng-if="item.IsCoupon">
                  <img data-ng-src="{{getThemeUrl('/images/manufacturercouponicon.gif')}}" data-ng-show="item.ItemTypeId == 13"/>
                  <img data-ng-src="{{getThemeUrl('/images/manufacturercouponicon.gif')}}" data-ng-show="item.ItemTypeId == 2"/>
                  {{item.PriceString}}
                </span>
                <div data-ng-bind-html="item.Description | trustedHtml"></div>
                <div data-ng-hide="item.IsCoupon" class="price">{{item.PriceString}}</div>
                <div data-ng-show="item.ItemTypeId == 13">Redeemable one time only.</div>
                <input style="height: 20px;" placeholder="Comment" data-ng-hide="item.IsCoupon" data-ng-model="item.Comment" ui-keypress="{13:'doUpdateQuantity(item)'}" />
              </div>
              <div class="col-md-4 col-xs-4">
                <input class="btn btn-xs quantity" style="width: 35px" data-ng-show="!item.IsCoupon" name="quantity" data-ng-model="item.NewQuantity" />
                <button class="btn btn-primary btn-xs" data-ng-click="doUpdateQuantity(item)" data-ng-hide="item.IsCoupon">Update</button>
                <button class="btn btn-primary btn-xs" data-ng-click="doItemRemove(item)">Remove</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3" style="margin-left: -15px;">
      <div class="row" data-gsn-ad-unit="4" data-ng-if="',visible-lg,visible-md'.indexOf(bsDisplayMode) > 0"></div>
    </div>
  </div>


