<?php
/*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2023 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license.
*/

require 'scripts/pi-hole/php/header_authenticated.php';
?>
<div class="row">
        <div class="col-lg-6">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h1 class="box-title">Upstream DNS Servers</h1>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th colspan="2">IPv4</th>
                                        <th colspan="2">IPv6</th>
                                        <th>Name</th>
                                    </tr>
                                </thead>
                                <tbody id="DNSupstreamsTable">
                                </tbody>
                            </table>
                            <p>ECS (Extended Client Subnet) defines a mechanism for recursive resolvers to send partial client IP address information to authoritative DNS name servers. Content Delivery Networks (CDNs) and latency-sensitive services use this to give geo-located responses when responding to name lookups coming through public DNS resolvers. <em>Note that ECS may result in reduced privacy.</em></p>
                        </div>
                        <div class="col-sm-12">
                            <div class="box collapsed-box">
                                <div class="box-header with-border pointer no-user-select" data-widget="collapse">
                                    <h3 class="box-title">Custom DNS servers <span id="custom-servers-title"></span></h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="box-body">
                                    <p>The following list contains all DNS servers selected above. Furthermore, you can add your own custom DNS servers here. The expected format is one server per line in form of <code>IP#port</code>, where the <code>port</code> is optional. If given, it has to be separated by a hash <code>#</code> from the address (e.g. <code>127.0.0.1#5335</code> for a local <code>unbound</code> istance running on port <code>5335</code>). The port defaults to 53 if omitted.</p>
                                    <textarea class="form-control" rows="3" id="DNSupstreamsTextfield" placeholder="Enter upstream DNS servers, one per line" style="resize: vertical;"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overlay" id="dns-upstreams-overlay">
                        <i class="fa fa-sync fa-spin"></i>
                    </div>
                </div>
            </div>
            <div class="box box-warning settings-level-1">
                <div class="box-header with-border">
                    <h3 class="box-title">Conditional forwarding&nbsp;&nbsp;<i class="fas fa-wrench" title="This is an advanced-level setting"></i></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <p>If not configured as your DHCP server, Pi-hole typically won't be able to
                                determine the names of devices on your local network.  As a
                                result, tables such as Top Clients will only show IP addresses.</p>
                            <p>One solution for this is to configure Pi-hole to forward these
                                requests to your DHCP server (most likely your router), but only for devices on your
                                home network.  To configure this we will need to know the IP
                                address of your DHCP server and which addresses belong to your local network.
                                Exemplary input is given below as placeholder in the text boxes (if empty).</p>
                            <p>If your local network spans 192.168.0.1 - 192.168.0.255, then you will have to input
                                <code>192.168.0.0/24</code>. If your local network is 192.168.47.1 - 192.168.47.255, it will
                                be <code>192.168.47.0/24</code> and similar. If your network is larger, the CIDR has to be
                                different, for instance a range of 10.8.0.1 - 10.8.255.255 results in <code>10.8.0.0/16</code>,
                                whereas an even wider network of 10.0.0.1 - 10.255.255.255 results in <code>10.0.0.0/8</code>.
                                Setting up IPv6 ranges is exactly similar to setting up IPv4 here and fully supported.
                                Feel free to reach out to us on our
                                <a href="https://discourse.pi-hole.net" rel="noopener" target="_blank">Discourse forum</a>
                                in case you need any assistance setting up local host name resolution for your particular system.</p>
                            <p>You can also specify a local domain name (like <code>fritz.box</code>) to ensure queries to
                                devices ending in your local domain name will not leave your network, however, this is optional.
                                The local domain name must match the domain name specified
                                in your DHCP server for this to work. You can likely find it within the DHCP settings.</p>
                            <p>Enabling Conditional Forwarding will also forward all hostnames (i.e., non-FQDNs) to the router
                                when "Never forward non-FQDNs" is <em>not</em> enabled.</p>
                            <div class="form-group">
                                <div>
                                    <input type="checkbox" id="dns.revServer.active">
                                    <label for="dns.revServer.active"><strong>Use Conditional Forwarding</strong></label>
                                </div>
                                <div class="input-group">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Local network in <a href="https://en.wikipedia.org/wiki/Classless_Inter-Domain_Routing" target="_blank">CIDR notation</a></th>
                                                <th>IP address of your DHCP server (router)</th>
                                                <th>Local domain name (optional)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" id="dns.revServer.cidr" placeholder="192.168.0.0/16" class="form-control" autocomplete="off" spellcheck="false" autocapitalize="none" autocorrect="off" value="">
                                                </td>
                                                <td>
                                                    <input type="text" id="dns.revServer.target" placeholder="192.168.0.1" class="form-control" autocomplete="off" spellcheck="false" autocapitalize="none" autocorrect="off" value="">
                                                </td>
                                                <td>
                                                    <input type="text" id="dns.revServer.domain" placeholder="local" class="form-control" data-mask autocomplete="off" spellcheck="false" autocapitalize="none" autocorrect="off" value="">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 settings-level-1">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h1 class="box-title">Interface settings&nbsp;&nbsp;<i class="fas fa-wrench" title="This is an advanced-level setting"></i></h1>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <div class="no-danger-area">
                                    <h4>Recommended setting</h4>
                                    <div>
                                        <input type="radio" name="DNSinterface" id="dns.listeningMode-LOCAL">
                                        <label for="dns.listeningMode-LOCAL"><strong>Allow only local requests</strong><br>Allows only queries from devices that are at most one hop away (local devices)</label>
                                    </div>
                                </div>
                                <div class="danger-area">
                                    <h4>Potentially dangerous options</h4>Make sure your Pi-hole is properly firewalled!
                                    <div>
                                        <input type="radio" name="DNSinterface" id="dns.listeningMode-SINGLE">
                                        <label for="dns.listeningMode-SINGLE"><strong>Respond only on interface <span id="interface-name-1"></span></strong></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="DNSinterface" id="dns.listeningMode-BIND">
                                        <label for="dns.listeningMode-BIND"><strong>Bind only to interface <span id="interface-name-2"></span></strong></label>
                                    </div>
                                    <div>
                                        <input type="radio" name="DNSinterface" id="dns.listeningMode-ALL">
                                        <label for="dns.listeningMode-ALL"><strong>Permit all origins</strong></label>
                                    </div>
                                    <p>These options are dangerous on devices
                                        directly connected to the Internet such as cloud instances and are only safe if your
                                        Pi-hole is properly firewalled. In a typical at-home setup where your Pi-hole is
                                        located within your local network (and you have <strong>not</strong> forwarded port 53
                                        in your router!) they are safe to use.</p>
                                </div>
                            </div>
                            <p>See <a href="https://docs.pi-hole.net/ftldns/interfaces/" target="_blank">our documentation</a> for further technical details.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Advanced DNS settings</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div>
                                <input type="checkbox" id="dns.domainNeeded" title="domain-needed">
                                <label for="dns.domainNeeded"><strong>Never forward non-FQDN <code>A</code> and <code>AAAA</code> queries</strong></label>
                                <p>Tells Pi-hole to never forward A or AAAA queries for plain
                                    names, without dots or domain parts, to upstream nameservers. If
                                    the name is not known from <code>/etc/hosts</code> or DHCP then a "not found"
                                    answer is returned.<br>
                                    If Conditional Forwarding is enabled, unticking this box may cause a partial
                                    DNS loop under certain circumstances (e.g. if a client would send TLD DNSSEC queries).</p>
                            </div>
                            <br>
                            <div>
                                <input type="checkbox" id="dns.bogusPriv" title="bogus-priv">
                                <label for="dns.bogusPriv"><strong>Never forward reverse lookups for private IP ranges</strong></label>
                                <p>All reverse lookups for private IP ranges (i.e., <code>192.168.0.x/24</code>, etc.)
                                    which are not found in <code>/etc/hosts</code> or the DHCP leases are answered
                                    with "no such domain" rather than being forwarded upstream. The set
                                    of prefixes affected is the list given in <a href="https://tools.ietf.org/html/rfc6303">RFC6303</a>.</p>
                                    <p><strong>Important</strong>: Enabling these two options may increase your privacy,
                                    but may also prevent you from being able to access
                                    local hostnames if the Pi-hole is not used as DHCP server.</p>
                            </div>
                            <br>
                            <div>
                                <input type="checkbox" id="dns.dnssec">
                                <label for="dns.dnssec"><strong>Use DNSSEC</strong></label>
                                <p>Validate DNS replies and cache DNSSEC data. When forwarding DNS
                                    queries, Pi-hole requests the DNSSEC records needed to validate
                                    the replies. If a domain fails validation or the upstream does not
                                    support DNSSEC, this setting can cause issues resolving domains.
                                    Use an upstream DNS server which supports DNSSEC when activating DNSSEC. Note that
                                    the size of your log might increase significantly
                                    when enabling DNSSEC. A DNSSEC resolver test can be found
                                    <a href="https://dnssec.vs.uni-due.de/" rel="noopener" target="_blank">here</a>.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-warning settings-level-1">
                <div class="box-header with-border">
                    <h3 class="box-title">Rate-limiting&nbsp;&nbsp;<i class="fas fa-wrench" title="This is an advanced-level setting"></i></h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <p>Block clients making more than <input type="number" id="dns.rateLimit.count" value="" min="0" step="10" style="width: 5em;"> queries within
                                <input type="number" id="dns.rateLimit.interval" value="" min="0" step="10" style="width: 4em;"> seconds.</p>
                                <p>When a client makes too many queries in too short time, it
                                gets rate-limited. Rate-limited queries are answered with a
                                <code>REFUSED</code> reply and not further processed by FTL
                                and prevent Pi-holes getting overwhelmed by rogue clients.
                                It is important to note that rate-limiting is happening on a
                                per-client basis. Other clients can continue to use FTL while
                                rate-limited clients are short-circuited at the same time.</p>
                            <p>Rate-limiting may be disabled altogether by setting both
                                values to zero. See
                                <a href="https://docs.pi-hole.net/ftldns/configfile/#rate_limit" target="_blank">our documentation</a>
                                for further details.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 settings-level-1">
            <button type="submit" class="btn btn-primary pull-right">Save</button>
        </div>
    </div>
</div>
<script src="<?php echo fileversion('scripts/pi-hole/js/settings-dns.js'); ?>"></script>
<script src="<?php echo fileversion('scripts/pi-hole/js/settings.js'); ?>"></script>

<?php
require 'scripts/pi-hole/php/footer.php';
?>