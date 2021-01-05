<?php
    use Pixelarbeit\CF7WeClapp\Config\FormConfigController;
    use Pixelarbeit\CF7WeClapp\Config\Config;

    $fcc = FormConfigController::getInstance();
    $options = Config::getOptions($fcc->getCurrentFormId());
?>

<div class="weclapp-config">
    <h2>WeClapp Configuration</h2>

    <h3>Options</h3>

    <table class="mapping">
        <thead>
            <tr>
                <td>Option</td>
                <td>Value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Active</th>
                <td>
                    <input type="checkbox" name="wpcf7-weclapp_options[active]" <?php if (isset($options['active']) && $options['active'] == true): ?>checked<?php endif; ?>>
                </td>
            </tr>
            <tr>
                <th>Group</th>
                <td>
                    <select name="wpcf7-weclapp_options[type]">
                        <option value="contact" <?php if (isset($options['type']) && $options['type'] == 'contact'): ?>selected<?php endif; ?>>Contact</option>
                        <option value="customer" <?php if (isset($options['type']) && $options['type'] == 'customer'): ?>selected<?php endif; ?>>Customer</option>
                        <option value="lead" <?php if (isset($options['type']) && $options['type'] == 'lead'): ?>selected<?php endif; ?>>Lead</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Party Type</th>
                <td>
                    <select name="wpcf7-weclapp_options[partyType]">
                        <option value="PERSON" <?php if (isset($options['type']) && $options['partyType'] == 'PERSON'): ?>selected<?php endif; ?>>Person</option>
                        <option value="ORGANIZATION"  <?php if (isset($options['type']) && $options['partyType'] == 'ORGANIZATION'): ?>selected<?php endif; ?>>Organisation</option>
                    </select>
                </td>
            </tr>
        </tbody>
    </table>
    <br><br><br>
    <h3>Mapping</h3>
    <p>
        This configuration sets the mapping from the CF7 field names to WeClapp properties.
    </p>
    <p>
        Fields marked with * are required for WeClapp contacts.
    </p>

    <h4>Person/Organisation</h4>
    <table class="mapping">
        <thead>
            <tr>
                <td>WeClapp Field</td>
                <td>CF7 Field</td>
                <td>CF7 Value -> WeClapp Value</td>
            </tr>
        </thead>
        <tbody>
        <tr class="hasNote">
                <th>Party Type</th>
                <td>
                    <?php $fcc->printKeyMappingBox('partyType'); ?>
                </td>
                <td>
                    <?php $fcc->printValueMappingBox('partyType', ['PERSON', 'ORGANIZATION']); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <small>Will overwrite default party type from options when mapped..</small>
                </td>
            </tr>
            <tr>
                <th>Salutation</th>
                <td>
                    <?php $fcc->printKeyMappingBox('salutation'); ?>
                </td>
                <td>
                    <?php $fcc->printValueMappingBox('salutation', ['MR', 'MRS', 'COMPANY', 'FAMILY']); ?>
                </td>
            </tr>
            <tr>
                <th>First Name</th>
                <td>
                    <?php $fcc->printKeyMappingBox('firstName'); ?>
                </td>
                <td></td>
            </tr>
            <tr class="hasNote">
                <th>Last Name*</th>
                <td>
                    <?php $fcc->printKeyMappingBox('lastName'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <small>Last Name is minimum requirement for Party Type "Person".</small>
                </td>
            </tr>
            <tr>
                <th>Company Name*</th>
                <td>
                    <?php $fcc->printKeyMappingBox('company'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <small>Company is minimum requirement for Party Type "Organisation".</small>
                </td>
            </tr>
            <tr>
                <th>Company*</th>
                <td>
                    <?php $fcc->printKeyMappingBox('personCompany'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <small>The persons company. For Party Type "Person".</small>
                </td>
            </tr>
        </tbody>
    </table>

    <table class="mapping">
        <thead>
            <tr>
                <td>WeClapp Field</td>
                <td>CF7 Field</td>
                <td>CF7 Value -> WeClapp Value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Email</th>
                <td>
                    <?php $fcc->printKeyMappingBox('email'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>
                    <?php $fcc->printKeyMappingBox('phone'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>
                    <?php $fcc->printKeyMappingBox('mobilePhone1'); ?>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <table class="mapping">
        <thead>
            <tr>
                <td>WeClapp Field</td>
                <td>CF7 Field</td>
                <td>CF7 Value -> WeClapp Value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Street</th>
                <td>
                    <?php $fcc->printKeyMappingBox('addresses.0.street1'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>Zipcode</th>
                <td>
                    <?php $fcc->printKeyMappingBox('addresses.0.zipcode'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>City</th>
                <td>
                    <?php $fcc->printKeyMappingBox('addresses.0.city'); ?>
                </td>
                <td></td>
            </tr>
            <tr class="hasNote">
                <th>Country Code*</th>
                <td>
                    <?php $fcc->printKeyMappingBox('addresses.0.countryCode'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <small>Country Code is only required when adding an address</small>
                </td>
            </tr>
        </tbody>
    </table>

    <h4>Contact Person</h4>
    <table class="mapping">
        <thead>
            <tr>
                <td>WeClapp Field</td>
                <td>CF7 Field</td>
                <td>CF7 Value -> WeClapp Value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Salutation</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.salutation'); ?>
                </td>
                <td>
                    <?php $fcc->printValueMappingBox('contacts.0.salutation', ['MR', 'MRS', 'COMPANY', 'FAMILY']); ?>
                </td>
            </tr>
            <tr>
                <th>First Name</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.firstName'); ?>
                </td>
                <td></td>
            </tr>
            <tr class="hasNote">
                <th>Last Name*</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.lastName'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <small>Last Name is minimum requirement.</small>
                </td>
            </tr>
            <tr>
                <th>Company*</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.company'); ?>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table class="mapping">
        <thead>
            <tr>
                <td>WeClapp Field</td>
                <td>CF7 Field</td>
                <td>CF7 Value -> WeClapp Value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Email</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.email'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.phone'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.mobilePhone1'); ?>
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <table class="mapping">
        <thead>
            <tr>
                <td>WeClapp Field</td>
                <td>CF7 Field</td>
                <td>CF7 Value -> WeClapp Value</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>Street</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.addresses.0.street1'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>Zipcode</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.addresses.0.zipcode'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <th>City</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.addresses.0.city'); ?>
                </td>
                <td></td>
            </tr>
            <tr class="hasNote">
                <th>Country Code*</th>
                <td>
                    <?php $fcc->printKeyMappingBox('contacts.0.addresses.0.countryCode'); ?>
                </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="3">
                    <small>Country Code is only required when adding an address</small>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<style>
    .weclapp-config h4 {
        font-size: 1.2em;
        margin-top: 3em;
    }

    .mapping {
        width: 100%;
        text-align: left;
        border-collapse: collapse;
        margin-bottom: 1.5em;
    }

    .mapping th, .mapping td {
        padding: .5em;
        vertical-align: top;
        border-bottom: 1px solid #ccc;
    }

    .mapping th {
        line-height: 2em;
    }

    .mapping thead td {
        font-style: italic;
    }
    .mapping table td,
    .mapping table th {
        border-bottom: none;
        padding: 0 .5em;
        vertical-align: middle;
    }

    .mapping tr.hasNote th, .mapping tr.hasNote td {
        border-bottom: none;
    }

</style>
