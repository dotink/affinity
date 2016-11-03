# Engine
## The engine is responsible for executing all bootstrap logic and providing access to configs

_Copyright (c) 2015, Matthew J. Sahagian_.
_Please reference the LICENSE.md file at the root of this distribution_

#### Namespace

`Affinity`

#### Imports

<table>

	<tr>
		<th>Alias</th>
		<th>Namespace / Class</th>
	</tr>
	
	<tr>
		<td>Flourish</td>
		<td>Dotink\Flourish</td>
	</tr>
	
</table>

#### Authors

<table>
	<thead>
		<th>Name</th>
		<th>Handle</th>
		<th>Email</th>
	</thead>
	<tbody>
	
		<tr>
			<td>
				Matthew J. Sahagian
			</td>
			<td>
				mjs
			</td>
			<td>
				msahagian@dotink.org
			</td>
		</tr>
	
	</tbody>
</table>

## Properties

### Instance Properties
#### <span style="color:#6a6e3d;">$actions</span>

The actions registered for the engine

#### <span style="color:#6a6e3d;">$configs</span>

The configs registered for the engine

#### <span style="color:#6a6e3d;">$context</span>

The context registered for the engine

#### <span style="color:#6a6e3d;">$drivers</span>

The drivers registered for the engine

#### <span style="color:#6a6e3d;">$settled</span>

Dependencies which have already been settled




## Methods

### Instance Methods
<hr />

#### <span style="color:#3e6a6e;">__construct()</span>

Create a new engine with any number of drivers

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$driver
			</td>
			<td>
									<a href="../../interfaces/Affinity/DriverInterface.md">DriverInterface</a>
				
			</td>
			<td>
				A driver for loading actions / configs
			</td>
		</tr>
					
		<tr>
			<td>
				$...
			</td>
			<td>
									<a href="../../interfaces/Affinity/DriverInterface.md">DriverInterface</a>
				
			</td>
			<td>
				ad infinitum
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">addAction()</span>

Add an action to the engine under a specific key ID

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$key
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The specific key ID
			</td>
		</tr>
					
		<tr>
			<td>
				$action
			</td>
			<td>
									<a href="../../interfaces/Affinity/ActionInterface.md">ActionInterface</a>
				
			</td>
			<td>
				The action to add
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">addConfig()</span>

Add a config to the engine under a specific key ID

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$key
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The specific key ID
			</td>
		</tr>
					
		<tr>
			<td>
				$config
			</td>
			<td>
									<a href="../../interfaces/Affinity/ConfigInterface.md">ConfigInterface</a>
				
			</td>
			<td>
				The config to add
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">exec()</span>

Execute a provide action operation

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$callback
			</td>
			<td>
									callable				
			</td>
			<td>
				The callback for the operation
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The result of the operation
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">fetch()</span>

Fetch a specific key ID or aggregate ID's configuration values

##### Details

The param can be a string formatted as a JS object (example.property) which will
resolve subparameters.  If a default is provided that will be returned if the value
does not exist, NULL will be returned otherwise.

In the case of aggregate IDs, the returned value will be an array.  If no parameter
is specified the array will contain the specific key IDs for configs which contain
the aggregate type.  Otherwise, the data will be the value of the array and the key
will be the specific ID.

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$id
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The config ID to fetch, aggregate IDs are preceded with `@`
			</td>
		</tr>
					
		<tr>
			<td>
				$param
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The param to fetch, can be JS style object notation
			</td>
		</tr>
					
		<tr>
			<td>
				$default
			</td>
			<td>
									<a href="http://php.net/language.pseudo-types">mixed</a>
				
			</td>
			<td>
				The default value if not found, `NULL` is the default default
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			mixed
		</dt>
		<dd>
			The resolved configuration value
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">start()</span>

Start the engine for given environments and context

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$environments
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				A comma separated list of non-default environments to load
			</td>
		</tr>
					
		<tr>
			<td>
				$context
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The context to provide drivers and pass to operations
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			void
		</dt>
		<dd>
			Provides no return value.
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">mapChildDependencies()</span>

Map all child dependencies for a given action key

###### Parameters

<table>
	<thead>
		<th>Name</th>
		<th>Type(s)</th>
		<th>Description</th>
	</thead>
	<tbody>
			
		<tr>
			<td>
				$key
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The key for the action whose dependencies we're mapping
			</td>
		</tr>
					
		<tr>
			<td>
				$sub_key
			</td>
			<td>
									<a href="http://php.net/language.types.string">string</a>
				
			</td>
			<td>
				The child key we're mapping
			</td>
		</tr>
					
		<tr>
			<td>
				$map
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The original dependency map
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			array
		</dt>
		<dd>
			The new dependency map with child dependencies expanded
		</dd>
	
</dl>






