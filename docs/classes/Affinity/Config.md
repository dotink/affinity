# Config
## The configuration class encapsulates configuration data

_Copyright (c) 2015, Matthew J. Sahagian_.
_Please reference the LICENSE.md file at the root of this distribution_

#### Namespace

`Affinity`

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
#### <span style="color:#6a6e3d;">$data</span>

The configuration data for this config

#### <span style="color:#6a6e3d;">$types</span>

The types of configuration data this config contains




## Methods
### Static Methods
<hr />

#### <span style="color:#3e6a6e;">create()</span>

A simple factory method to create a new config

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
				$types
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The list of types in the configuration data
			</td>
		</tr>
					
		<tr>
			<td>
				$data
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The configuration data
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			Config
		</dt>
		<dd>
			The constructed configuration
		</dd>
	
</dl>




### Instance Methods
<hr />

#### <span style="color:#3e6a6e;">__construct()</span>

Create a new config

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
				$types
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The list of types in the configuration data
			</td>
		</tr>
					
		<tr>
			<td>
				$data
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The configuration data
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			Config
		</dt>
		<dd>
			The constructed configuration
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">extend()</span>

Extend a config by merging configuration data

##### Details

Note that this modifies the original config as opposed to creating a new config.
The config returned will be the same one you called `extend()` on but will have a
modified data and types.

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
				$config
			</td>
			<td>
									<a href="../../interfaces/Affinity/ConfigInterface.md">ConfigInterface</a>
				
			</td>
			<td>
				The config with which to extend this one
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			Config
		</dt>
		<dd>
			the extended config
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getData()</span>

Get the data for this config

###### Returns

<dl>
	
		<dt>
			array
		</dt>
		<dd>
			The data for this config
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getTypes()</span>

Get the types for this config

###### Returns

<dl>
	
		<dt>
			array
		</dt>
		<dd>
			The types for this config
		</dd>
	
</dl>






