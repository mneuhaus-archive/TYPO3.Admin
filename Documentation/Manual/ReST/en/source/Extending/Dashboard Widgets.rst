Dashboard Widgets
#################

DashboardWidgets are shown on the Expose main page and need to implement the function "initializeWidget".

Example
*******

**LogWidget.php**::

    /**
     *
     * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
     */
    class LogWidget extends \Expose\Core\DashboardWidgets\AbstractDashboardWidget {
        public function initializeWidget() {
            $query = $this->objectManager->get("\Expose\Domain\Repository\LogRepository")->createQuery();
            $query->setOrderings(array(
                "datetime" => 'ASC'
            ));
            $query->setLimit("10");
            $logs = $query->execute();
            $this->view->assign("logs", $logs);
        }
    }

**Private/Partials/DashboardWidgets/Log.html**::

    <h5 class="well-header">Recent Activity</h5>
    <f:if condition="{logs.count} > 0" >
        <f:then>
            <table class="zebra-striped condensed-table cozy">
                <thead>
                <tr>
                    <th>Type</th>
                    <th>Action</th>
                    <th>User</th>
                </tr>
                </thead>
                <f:for each="{logs}" as="log">
                    <tr>
                        <td>{log.being}</td>
                        <td>
                            <span class="label">{log.action}</span>
                        </td>
                        <td>{log.user}</td>
                    </tr>
                </f:for>
            </table>
        </f:then>
        <f:else>
            No actions yet.
        </f:else>
    </f:if>