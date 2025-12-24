<?php
/** 
 * Nama Class: Form 
 * Deskripsi: Class untuk membuat form inputan dinamis (Text, Textarea, Select, Radio, Checkbox, File) 
 */ 
class Form {
    private $fields = array();
    private $action;
    private $submit = "Submit Form";
    private $jumField = 0;
    private $enctype = false;  // Auto set kalau ada file

    public function __construct($action, $submit) {
        $this->action = $action;
        $this->submit = $submit;
    }

    public function displayForm() {
        $enc = $this->enctype ? "enctype='multipart/form-data'" : "";
        echo "<form action='" . htmlspecialchars($this->action) . "' method='POST' $enc>";
        echo '<table width="100%" border="0">';

        foreach ($this->fields as $field) {
            echo "<tr><td align='right' valign='top'>" . htmlspecialchars($field['label']) . "</td>";
            echo "<td>";

            // Logika untuk menentukan tipe input 
            switch ($field['type']) {
                case 'textarea':
                    echo "<textarea name='" . htmlspecialchars($field['name']) . "' cols='30' rows='4'>" . 
                         htmlspecialchars($field['value'] ?? '') . "</textarea>";
                    break;

                case 'select':
                    echo "<select name='" . htmlspecialchars($field['name']) . "'>";
                    foreach ($field['options'] as $value => $label) {
                        $selected = ($value == ($field['value'] ?? '')) ? ' selected' : '';
                        echo "<option value='" . htmlspecialchars($value) . "'$selected>" . 
                             htmlspecialchars($label) . "</option>";
                    }
                    echo "</select>";
                    break;

                case 'radio':
                    foreach ($field['options'] as $value => $label) {
                        $checked = ($value == ($field['value'] ?? '')) ? ' checked' : '';
                        echo "<label><input type='radio' name='" . htmlspecialchars($field['name']) . 
                             "' value='" . htmlspecialchars($value) . "'$checked> " . 
                             htmlspecialchars($label) . "</label> ";
                    }
                    break;

                case 'checkbox':
                    $values = (array)($field['value'] ?? []);
                    foreach ($field['options'] as $value => $label) {
                        $checked = in_array($value, $values) ? ' checked' : '';
                        echo "<label><input type='checkbox' name='" . htmlspecialchars($field['name']) . 
                             "[]' value='" . htmlspecialchars($value) . "'$checked> " . 
                             htmlspecialchars($label) . "</label> ";
                    }
                    break;

                case 'password':
                    echo "<input type='password' name='" . htmlspecialchars($field['name']) . 
                         "' value='" . htmlspecialchars($field['value'] ?? '') . "'>";
                    break;

                case 'file':
                    $this->enctype = true;  // Auto set enctype
                    echo "<input type='file' name='" . htmlspecialchars($field['name']) . "'>";
                    break;

                default: // text atau lain
                    echo "<input type='" . htmlspecialchars($field['type']) . "' name='" . 
                         htmlspecialchars($field['name']) . "' value='" . 
                         htmlspecialchars($field['value'] ?? '') . "'>";
                    break;
            }

            echo "</td></tr>";
        }

        echo "<tr><td colspan='2'>";
        echo "<input type='submit' value='" . htmlspecialchars($this->submit) . "'></td></tr>";
        echo "</table>";
        echo "</form>";
    }

    /** 
     * addField 
     * @param string $name Nama atribut (name="") 
     * @param string $label Label untuk field 
     * @param string $type Tipe input (text, textarea, select, radio, checkbox, password, file)
     * @param string $value Nilai default (opsional)
     * @param array $options Opsi untuk select/radio/checkbox (format: ['value' => 'Label']) 
     */
    public function addField($name, $label, $type = "text", $value = '', $options = array()) {
        $this->fields[$this->jumField] = [
            'name' => $name,
            'label' => $label,
            'type' => $type,
            'value' => $value,
            'options' => $options
        ];
        $this->jumField++;
    }
}