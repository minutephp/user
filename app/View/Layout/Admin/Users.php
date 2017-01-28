<minute-include-content></minute-include-content>

<div ng-controller="UserLayoutController as members" id="UserLayoutContainer">
    <minute-event name="import.members.user.tabs" as="data.tabs"></minute-event>
</div>

<script>
    angular.bootstrap(document.getElementById("UserLayoutContainer"), ['UserLayoutApp']);
</script>
