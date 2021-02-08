### Simple Template Engine

Based on XML and allows defining custom elements using PHP.

```xml
<bs:Page xmlns:bs="Atom.Bootstrap">
    <h2>UI Example</h2>
    <hr />

    <bs:Alert type="info">Alert</bs:Alert>

    <bs:Form title="Create User" method="post">
        <bs:FormGroup>
            <bs:Entry type="text" label="First Name" class="col-6" />
            <bs:Entry type="text" label="Last Name"  class="col-6" />
        </bs:FormGroup>

        <bs:Entry type="email" label="Email" />
        <bs:Entry type="password" label="Password" class="mt-3"/>
        <bs:Entry type="password" label="Retype Password" />

        <bs:Entry type="select" label="User Type" class="my-3"/>
        <bs:Entry type="checkbox" label="Active" class="my-3" />
    </bs:Form>
</bs:Page>
```

Xml definition above constructs component tree similar to following code:

```php
use Atom\Bootstrap\Page;
use Atom\Bootstrap\Alert;
use Atom\Bootstrap\Form;

$view = new Page("bs:Page", [], [
    new Component("h2", [], new TextComponent("UI Example")),
    new Alert("bs:Alert", ["type" => "info"], new TextComponent("Alert")),
    new Form("bs:Form", ["title" => "Create User", "method" => "post"], [
        new FormGroup("bs:FormGroup", [], [
            new Entry("bs:Entry", ["label" => "First Name", "class"="col-6"]),
            new Entry("bs:Entry", ["label" => "Last Name", "class"="col-6"]),
        ]),
        new Entry("bs:Entry", ["type" =>"email", "label" => "Email"]),
        new Entry("bs:Entry", ["type" =>"password", "label" => "Password", "class"="my-3"]),
        new Entry("bs:Entry", ["type" =>"password", "label" => "Retype Password"]),
        new Entry("bs:Entry", ["type" =>"select", "label" => "User Type" "class"="my-3"]),
        new Entry("bs:Entry", ["type" =>"checkbox", "label" => "Active", "class"="my-3"]),
    ])
])
```

A component is lowered to primitive elements using render method.

```php
<?php
namespace Atom\Bootstrap;

use Atom\Xaml\Component\Component;

class Alert extends Component
{
    public string $type = "";

    public function render() {
        return new Component(
            "div",
            $this->mergeAttributes([
                "class" => "alert alert-{$this->type}"
            ]),
            $this->renderChildren()
        );
    }
}
```

Child components can be assigned to component properties using "slot" attribute.

```xml
<ns:Example>
    <div slot="sidebar">
        <!-- Sidebar -->
    </div>

    <div slot="menu">
        <!-- Menu -->
    </div>

    <h2></h2>
</ns:Example>
```

And use render() method to lower component to primitives when composing virtual dom.

```php
<?php

class Example extends Component
{
    public $sidebar = null;
    public $menu = null;

    public function render() {

        $sidebar = $this->sidebar ? $this->sidebar->render() : null;
        $menu = $this->menu ? $this->menu->render() : null;
        $children = $this->renderChildren();

        return new Component("div",[],
            [
                new Component("div",["class" => "sidebar"], [$sidebar]),
                new Component("div",["class" => "menu"], [$menu]),
                new Component("div",["class" => "content"], $children),
            ]
        );
    }
}
```

###  Binding

> Support for simple binding is not yet implemented.

Idea is to implement something like following:

1. Use double curly brace to donate binding

```xml
<bs:Alert type="{{ type }}"> {{ message }} </bs:Alert>
```

2. Use dot syntax to access object property

```xml
<bs:Form>
    <bs:Entry name="first_name"
              value="{{ model.first_name }}"
              errorMessage="{{ model.errors.first_name }}" />
    <bs:Entry name="last_name"
              value="{{ model.last_name }}"
              errorMessage="{{ model.errors.last_name }}" />
</bs:Form>
```

3. Setting context on parent element

```xml
<bs:Form context="{{ model }}">
    <bs:Entry name="first_name" value="{{ first_name }}" errorMessage="{{ errors.first_name }}" />
    <bs:Entry name="last_name" value="{{ last_name }}" errorMessage="{{ errors.last_name }}"  />
</bs:Form>
```

4. Use convention for trivial cases

```xml
<bs:Form context="{{ model }}">
    <bs:Entry name="first_name" />
    <bs:Entry name="last_name" />
</bs:Form>
```
