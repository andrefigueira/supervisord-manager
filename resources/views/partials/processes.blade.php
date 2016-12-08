<section class="process-list" v-if="!process" v-cloak>
    <table class="table">
        <tr>
            <td>PID</td>
            <td>Group</td>
            <td>Name</td>
            <td>Exit status</td>
            <td>State</td>
            <td>Started</td>
            <td></td>
        </tr>
        <tr v-for="process in processes">
            <td>@{{ process.pid }}</td>
            <td>@{{ process.group }}</td>
            <td>@{{ process.name }}</td>
            <td>@{{ process.exitstatus }}</td>
            <td><span :class="'label ' + process.label">@{{ process.statename }}</span></td>
            <td>@{{ process.startdate }}</td>
            <td>
                <button v-if="process.statename == 'RUNNING'" :id="process.name + '-stop'" class="btn btn-danger btn-xs" @click="processAction(process.name, 'stop')"><i class="fa fa-stop" aria-hidden="true"></i></button>
                <button v-if="process.statename == 'STOPPED'" :id="process.name + '-start'" class="btn btn-success btn-xs" @click="processAction(process.name, 'start')"><i class="fa fa-play" aria-hidden="true"></i></button>
                <button class="btn btn-info btn-xs" @click="viewProcess(process)"><i class="fa fa-eye" aria-hidden="true"></i></button>
            </td>
        </tr>
    </table>
</section><!-- End process list -->


<section class="process" v-if="process" v-cloak>
    <h2>Process: @{{ process.name }} <button @click="hideProcess()" class="btn btn-xs btn-danger pull-right"><i class="fa fa-times" aria-hidden="true"></i></button></h2>

    <div>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#stdoutlog" aria-controls="stdoutlog" role="tab" data-toggle="tab">Standard Out Log</a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="stdoutlog">
                <code class="process-log-preview"><pre></pre></code>
            </div>
        </div>
    </div>
</section>