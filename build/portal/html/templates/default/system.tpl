{*

    ////////////////////////////////////////////////////////////////////////////////
    //                 ADS-B RECEIVER PORTAL TEMPLATE INFORMATION                 //
    // ========================================================================== //
    // Template Set: default                                                      //
    // Template Name: system.tpl                                                  //
    // Version: 2.0.0                                                             //
    // Release Date:                                                              //
    // Author: Joe Prochazka                                                      //
    // Website: https://www.swiftbyte.com                                         //
    // ========================================================================== //
    // Copyright and Licensing Information:                                       //
    //                                                                            //
    // Copyright (c) 2015-2016 Joseph A. Prochazka                                //
    //                                                                            //
    // This template set is licensed under The MIT License (MIT)                  //
    // A copy of the license can be found package along with these files.         //
    ////////////////////////////////////////////////////////////////////////////////

*}
{area:head/}
{area:contents}
            <div class="container">
                <h1>System Information</h1>
                <h2>Aggregate Sites Statistics</h2>
                <ul>
                    {if setting:enableFlightAwareLink eq TRUE}<li><a href="{page:flightAwareLink}" target="_blank">FlightAware Stats</a></li>{/if}
                    {if setting:enablePlaneFinderLink eq TRUE}<li><a href="{page:planeFinderLink}" target="_blank">Planefinder Stats</a></li>{/if}
                    {if setting:enableFlightRadar24Link eq TRUE}<li><a href="{page:flightRadar24Link}" target="_blank">Flightradar24 Stats</a></li>{/if}
                    {if setting:enableAdsbExchangeLink eq TRUE}<li><a href="{page:adsbExchangeLink}" target="_blank">ADS-B Exchange</a></li>{/if}
                </ul>
                <h2>System Charts</h2>
                <div id="chart_div" style="width: 400px; height: 120px;"></div>
                <div>
                    <strong>Uptime:</strong> <span id="uptime">{page:uptimeInSeconds}</span>
                </div>
                <h2>System Information</h2>
                <ul>
                    <li><strong>Portal Version:</strong> {page:portalVersion}</li>
                    <li><strong>Patch Version:</strong> {page:portalPatch}</li>
                </ul>
                <ul>
                    <li><strong>Name:</strong> {page:osNodeName}</li>
                    <li><strong>Kernel:</strong> {page:osKernelRelease}</li>
                    <li><strong>Machine:</strong> {page:osMachine}</li>
                </ul>
                <ul>
                    <li><strong>CPU Model:</strong> {page:cpuModel}</li>
                    <li><strong>Memory Installed:</strong> {page:memTotal}GB</li>
                </ul>
                <ul>
                    <li><strong>HDD Total:</strong> {page:hddTotal}GB</li>
                    <li><strong>HDD Used:</strong> {page:hddUsed}GB <i>({page:hddPercent}% used)</i></li>
                    <li><strong>HDD Free:</strong> {page:hddFree}GB</li>
                </ul>
            </div>
{/area}
{area:scripts}
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script>
            var bandwidthScale = '{setting:measurementBandwidth}';
        </script>
        <script src="/templates/{setting:template}/assets/js/system.js"></script>
{/area}
