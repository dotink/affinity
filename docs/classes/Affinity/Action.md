# Action
## The action class encapsulates an operation and dependencies for the operation

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
#### <span style="color:#6a6e3d;">$dependencies</span>

The dependency requirements for this action

#### <span style="color:#6a6e3d;">$operation</span>

The operation to perform when the action is executed




## Methods
### Static Methods
<hr />

#### <span style="color:#3e6a6e;">create()</span>

A simple factory method to create a new action

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
				$dependencies
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The list of dependencies for this action
			</td>
		</tr>
					
		<tr>
			<td>
				$operation
			</td>
			<td>
									callable				
			</td>
			<td>
				The operation to perform when the action is executed
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			Action
		</dt>
		<dd>
			The constructed action
		</dd>
	
</dl>




### Instance Methods
<hr />

#### <span style="color:#3e6a6e;">__construct()</span>

Create a new action

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
				$dependencies
			</td>
			<td>
									<a href="http://php.net/language.types.array">array</a>
				
			</td>
			<td>
				The list of dependencies for this action
			</td>
		</tr>
					
		<tr>
			<td>
				$operation
			</td>
			<td>
									callable				
			</td>
			<td>
				The operation to perform when the action is executed
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

#### <span style="color:#3e6a6e;">extend()</span>

Extend an action by appending additional logic

##### Details

Note that this modifies the original action as opposed to creating a new action.
The action returned will be the same one you called `extend()` on but will have a
modified operation and dependencies.

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
				$action
			</td>
			<td>
									<a href="../../interfaces/Affinity/ActionInterface.md">ActionInterface</a>
				
			</td>
			<td>
				The action with which to extend this one
			</td>
		</tr>
			
	</tbody>
</table>

###### Returns

<dl>
	
		<dt>
			Action
		</dt>
		<dd>
			the extended action
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getDependencies()</span>

Get the dependencies for this action

###### Returns

<dl>
	
		<dt>
			array
		</dt>
		<dd>
			The dependencies for the action
		</dd>
	
</dl>


<hr />

#### <span style="color:#3e6a6e;">getOperation()</span>

Get the operation for this action

###### Returns

<dl>
	
		<dt>
			callable
		</dt>
		<dd>
			The operation for this action
		</dd>
	
</dl>






