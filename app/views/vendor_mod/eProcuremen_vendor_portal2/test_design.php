<?php

 

 

require_once "../../../controllers/routing/default_values.php";
require_once SERVER_CORE."routing/layout.top.php";
?>

<style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>

    <h1>Welcome to your Sourcing Response Portal!</h1>
    <p>Supplier has been invited by Axiata Group of Companies to participate in a sourcing event for Test Event new 20. Participation and submission is easy and all done within the system. Response may require forms, attachments, price quotes, and/or descriptions of products or services. If you have responded to the event, please ignore this message.</p>
    <h2>All Sourcing Events</h2>
    <table>
        <thead>
            <tr>
                <th>Event #</th>
                <th>Event Name</th>
                <th>Per page</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Type</th>
                <th>Search</th>
                <th>Responses</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>41100</td>
                <td>Test Event new 20</td>
                <td>15 | 45 | 90</td>
                <td>02/20/24</td>
                <td>03/06/24</td>
                <td>Prod</td>
                <td>RFQ</td>
                <td></td>
                <td>0</td>
            </tr>
        </tbody>
    </table>

<?
require_once SERVER_CORE."routing/layout.bottom.php";
?>